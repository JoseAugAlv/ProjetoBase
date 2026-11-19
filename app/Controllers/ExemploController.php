<?php
// app/Controllers/ExemploController.php
// Exemplo de CRUD completo com CrudController (rota: /exemplo).
// Para criar o seu: php bin/console criar:crud nome_da_tabela

class ExemploController extends CrudController
{
    public function __construct()
    {
        $this->table = 'exemplo';
        $this->primaryKey = 'id_exemplo';

        // Colunas na ordem da lista e do formulário
        $this->fields = ['nome', 'descricao', 'status', 'data_criacao'];
        $this->requiredFields = ['nome'];
        $this->searchFields = ['nome', 'descricao'];

        // Campo com opções fixas vira <select> (e só aceita esses valores)
        $this->selectOptions = [
            'status' => ['ativo' => 'Ativo', 'inativo' => 'Inativo', 'pendente' => 'Pendente'],
        ];

        $this->labelSingular = 'Exemplo';
        $this->labelPlural = 'Exemplos';
        $this->defaultSort = 'nome';

        parent::__construct();
    }

    /** Regra extra de validação */
    protected function validateData(array $dados, ?int $id = null): void
    {
        parent::validateData($dados, $id);

        if (mb_strlen($dados['nome'] ?? '') < 3) {
            $this->failValidation('Nome deve ter no mínimo 3 caracteres.', $id);
        }
    }
}
