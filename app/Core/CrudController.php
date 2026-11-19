<?php
// app/Core/CrudController.php
// CRUD pronto para uma tabela: listar (com busca e paginação), criar, editar, excluir.
//
//   class ProdutoController extends CrudController {
//       public function __construct() {
//           $this->table = 'produto';
//           $this->primaryKey = 'id_produto';
//           $this->fields = ['nome', 'preco', 'ativo'];
//           $this->requiredFields = ['nome'];
//           $this->searchFields = ['nome'];
//           parent::__construct();
//       }
//   }
//   // routes/web.php:  $router->crud('produtos', 'ProdutoController', [1, 2]);
//
// Views: usa app/Views/{viewPrefix}/{index|criar|editar}.php se existir, senão app/Views/crud/.
// Exclusão é por POST; se a tabela tiver coluna `ativo`, só desativa (soft delete).

abstract class CrudController extends BaseController
{
    /** @var Model */
    protected $model;
    protected $table;
    protected $primaryKey = 'id';
    protected $perPage = 20;
    protected $fields = [];            // colunas exibidas/gravadas (ordem da lista e do formulário)
    protected $requiredFields = [];
    protected $searchFields = [];
    protected $selectOptions = [];     // ['status' => ['ativo' => 'Ativo', 'inativo' => 'Inativo']]
    protected $defaultSort = '';
    protected $defaultOrder = 'ASC';
    protected $viewPrefix = '';
    protected $routePrefix = '';
    protected $labelSingular = '';
    protected $labelPlural = '';
    protected $excludeFromList = ['senha', 'password', 'token'];
    protected $excludeFromForm = ['senha', 'password', 'token', 'data_criacao', 'data_atualizacao'];

    /** Obsoleto: o perfil agora é verificado na rota. Mantido para não quebrar filhos antigos. */
    protected $allowedRoles = [];

    public function __construct()
    {
        $this->model = new Model($this->table, $this->primaryKey);
        $this->viewPrefix = $this->viewPrefix ?: $this->table;
        $this->routePrefix = trim($this->routePrefix ?: $this->table, '/');
        $this->labelSingular = $this->labelSingular ?: ucfirst($this->table);
        $this->labelPlural = $this->labelPlural ?: ucfirst($this->table) . 's';

        if ($this->allowedRoles) {
            $this->requireRole($this->allowedRoles);
        }
    }

    // ------------------------------------------------------------
    // AÇÕES
    // ------------------------------------------------------------

    public function index()
    {
        $busca = mb_substr($this->input('busca'), 0, 100);
        $total = $this->getTotal($busca);
        $paginacao = PaginationHelper::paginate($total, max(1, $this->inputInt('pagina', 1)), $this->perPage);

        $this->renderView('index', [
            'registros' => $this->getList($this->perPage, $paginacao['offset'], $busca),
            'total' => $total,
            'busca' => $busca,
            'paginationHtml' => PaginationHelper::render(
                url('/' . $this->routePrefix),
                $paginacao['paginaAtual'],
                $paginacao['totalPaginas'],
                $busca !== '' ? ['busca' => $busca] : []
            ),
            'fields' => $this->getListFields(),
        ]);
    }

    public function criar()
    {
        $this->renderView('criar', ['fields' => $this->getFormFields()]);
    }

    public function salvar()
    {
        $dados = $this->sanitizeInput($_POST);
        $this->validateData($dados);

        $id = $this->model->insert($this->prepareInsertData($dados));
        $this->logAction('criar', "{$this->labelSingular} criado", $id);

        $this->redirectWith('/' . $this->routePrefix, 'sucesso', "{$this->labelSingular} criado com sucesso!");
    }

    public function editar()
    {
        $registro = $this->findOrFail($this->inputInt('id'));

        $this->renderView('editar', [
            'registro' => $registro,
            'id' => $registro[$this->primaryKey],
            'fields' => $this->getFormFields($registro),
        ]);
    }

    public function atualizar()
    {
        $id = $this->inputInt($this->primaryKey);
        $this->findOrFail($id);

        $dados = $this->sanitizeInput($_POST);
        $this->validateData($dados, $id);

        $this->model->update($id, $this->prepareUpdateData($dados));
        $this->logAction('atualizar', "{$this->labelSingular} atualizado", $id);

        $this->redirectWith('/' . $this->routePrefix, 'sucesso', "{$this->labelSingular} atualizado com sucesso!");
    }

    /** POST */
    public function excluir()
    {
        $id = $this->inputInt('id');
        $registro = $this->findOrFail($id);

        if (array_key_exists('ativo', $registro)) {
            $this->model->update($id, ['ativo' => 0]);
        } else {
            $this->model->delete($id);
        }
        $this->logAction('excluir', "{$this->labelSingular} removido", $id);

        $this->redirectWith('/' . $this->routePrefix, 'sucesso', "{$this->labelSingular} removido com sucesso!");
    }

    // ------------------------------------------------------------
    // PONTOS DE EXTENSÃO (sobrescreva no controller filho)
    // ------------------------------------------------------------

    protected function getList(int $limit, int $offset, string $busca = ''): array
    {
        [$where, $params] = $this->searchWhere($busca);
        $order = $this->defaultSort
            ? ' ORDER BY ' . self::col($this->defaultSort) . (strtoupper($this->defaultOrder) === 'DESC' ? ' DESC' : ' ASC')
            : ' ORDER BY ' . $this->primaryKey . ' DESC';

        $params[] = $limit;
        $params[] = $offset;
        return $this->model->query("SELECT * FROM {$this->table}{$where}{$order} LIMIT ? OFFSET ?", $params);
    }

    protected function getTotal(string $busca = ''): int
    {
        [$where, $params] = $this->searchWhere($busca);
        $row = $this->model->queryOne("SELECT COUNT(*) AS total FROM {$this->table}{$where}", $params);
        return (int) ($row['total'] ?? 0);
    }

    protected function getListFields(): array
    {
        return array_values(array_diff($this->fields, $this->excludeFromList));
    }

    protected function getFormFields(?array $registro = null): array
    {
        $fields = [];
        foreach (array_diff($this->fields, $this->excludeFromForm) as $field) {
            $fields[] = [
                'name' => $field,
                'value' => $registro[$field] ?? '',
                'required' => in_array($field, $this->requiredFields, true),
                'type' => isset($this->selectOptions[$field]) ? 'select' : $this->getFieldType($field),
                'options' => $this->selectOptions[$field] ?? [],
                'label' => $this->getFieldLabel($field),
            ];
        }
        return $fields;
    }

    protected function getFieldType(string $field): string
    {
        $types = [
            'email' => 'email',
            'senha' => 'password',
            'password' => 'password',
            'telefone' => 'tel',
            'ativo' => 'checkbox',
            'descricao' => 'textarea',
            'observacao' => 'textarea',
        ];
        if (isset($types[$field])) {
            return $types[$field];
        }
        if (strpos($field, 'data') === 0) {
            return 'date';
        }
        if (preg_match('/^(preco|valor|quantidade|qtd|total)/', $field)) {
            return 'number';
        }
        return 'text';
    }

    protected function getFieldLabel(string $field): string
    {
        $labels = [
            'nome' => 'Nome',
            'email' => 'E-mail',
            'telefone' => 'Telefone',
            'descricao' => 'Descrição',
            'data_nascimento' => 'Data de Nascimento',
            'data_criacao' => 'Criado em',
            'ativo' => 'Ativo',
        ];
        return $labels[$field] ?? ucfirst(str_replace('_', ' ', $field));
    }

    protected function prepareInsertData(array $dados): array
    {
        return $this->prepareUpdateData($dados);
    }

    protected function prepareUpdateData(array $dados): array
    {
        $data = [];
        foreach (array_diff($this->fields, $this->excludeFromForm) as $field) {
            if ($this->getFieldType($field) === 'checkbox') {
                $data[$field] = isset($dados[$field]) ? 1 : 0;   // checkbox desmarcado não vem no POST
            } elseif (array_key_exists($field, $dados)) {
                $valor = $dados[$field];
                $data[$field] = ($valor === '' && !in_array($field, $this->requiredFields, true)) ? null : $valor;
            }
        }
        // Só aceita opções válidas em campos select
        foreach ($this->selectOptions as $field => $opcoes) {
            if (isset($data[$field]) && !array_key_exists($data[$field], $opcoes)) {
                unset($data[$field]);
            }
        }
        return $data;
    }

    /** Valida obrigatórios. Sobrescreva para regras extras (chame parent::validateData primeiro). */
    protected function validateData(array $dados, ?int $id = null): void
    {
        $erros = [];
        foreach ($this->requiredFields as $field) {
            if (!isset($dados[$field]) || $dados[$field] === '') {
                $erros[] = 'O campo ' . $this->getFieldLabel($field) . ' é obrigatório.';
            }
        }
        if ($erros) {
            $this->failValidation(implode(' ', $erros), $id);
        }
    }

    /** Volta para o formulário com mensagem de erro. */
    protected function failValidation(string $mensagem, ?int $id = null): void
    {
        $destino = '/' . $this->routePrefix . ($id ? '/editar?id=' . $id : '/criar');
        $this->redirectWith($destino, 'erro', $mensagem);
    }

    protected function sanitizeInput(array $dados): array
    {
        return array_map(function ($v) {
            return is_string($v) ? trim($v) : $v;
        }, $dados);
    }

    protected function renderView(string $view, array $dados = []): void
    {
        $dados += [
            'labelSingular' => $this->labelSingular,
            'labelPlural' => $this->labelPlural,
            'routePrefix' => $this->routePrefix,
            'primaryKey' => $this->primaryKey,
            'tituloPagina' => ($view === 'index' ? $this->labelPlural : $this->labelSingular) . ' - ' . App::getName(),
        ];

        $especifica = $this->viewPrefix . '/' . $view;
        $this->view(is_file(APP_PATH . '/Views/' . $especifica . '.php') ? $especifica : 'crud/' . $view, $dados);
    }

    protected function logAction(string $acao, string $detalhes = '', ?int $id = null): void
    {
        $this->log($acao . '_' . $this->table, $detalhes . ($id ? " (ID {$id})" : ''), $this->table, $id);
    }

    // ------------------------------------------------------------

    protected function findOrFail(int $id): array
    {
        $registro = $id ? $this->model->find($id) : null;
        if (!$registro) {
            $this->redirectWith('/' . $this->routePrefix, 'erro', "{$this->labelSingular} não encontrado.");
        }
        return $registro;
    }

    private function searchWhere(string $busca): array
    {
        if ($busca === '' || empty($this->searchFields)) {
            return ['', []];
        }
        $partes = [];
        $params = [];
        foreach ($this->searchFields as $field) {
            $partes[] = self::col($field) . ' LIKE ?';
            $params[] = '%' . $busca . '%';
        }
        return [' WHERE (' . implode(' OR ', $partes) . ')', $params];
    }

    private static function col(string $nome): string
    {
        if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $nome)) {
            throw new InvalidArgumentException("Coluna inválida: {$nome}");
        }
        return $nome;
    }
}
