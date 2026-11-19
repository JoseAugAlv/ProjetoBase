<?php
// app/Models/Usuario.php — tabela `usuario`

class Usuario extends Model
{
    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';

    /** Colunas que podem ser gravadas por create()/update() */
    private const COLUNAS = [
        'nome', 'email', 'senha', 'telefone', 'data_nascimento', 'id_perfil',
        'ativo', 'email_verificado', 'token_verificacao', 'data_verificacao', 'google_id',
    ];

    /**
     * Valida os dados pessoais. Retorna a mensagem de erro ou null se estiver tudo certo.
     * Usado no cadastro, na edição do próprio perfil e na gestão de usuários.
     */
    public static function validarDados(string $nome, string $email, string $telefone = '', string $dataNascimento = ''): ?string
    {
        if ($nome === '' || $email === '') {
            return 'Nome e e-mail são obrigatórios.';
        }
        if (mb_strlen($nome) > 150) {
            return 'Nome muito longo (máx. 150 caracteres).';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 100) {
            return 'E-mail inválido.';
        }
        if ($telefone !== '' && !preg_match('/^[0-9()+\-\s]{8,20}$/', $telefone)) {
            return 'Telefone inválido.';
        }
        if ($dataNascimento !== '') {
            $data = DateTime::createFromFormat('!Y-m-d', $dataNascimento);
            if (!$data || $data->format('Y-m-d') !== $dataNascimento || $data > new DateTime('today')) {
                return 'Data de nascimento inválida.';
            }
        }
        return null;
    }

    public function findByEmail(string $email): ?array
    {
        return $this->findBy('email', trim($email));
    }

    /** Usuário + nome do perfil */
    public function findById(int $id): ?array
    {
        return $this->queryOne(
            "SELECT u.*, p.perfil AS nome_perfil
             FROM usuario u LEFT JOIN perfil p ON p.id_perfil = u.id_perfil
             WHERE u.id_usuario = ? LIMIT 1",
            [$id]
        );
    }

    /** Busca pelo token de verificação de e-mail (o banco guarda só o hash). */
    public function findByTokenVerificacao(string $token): ?array
    {
        if (!preg_match('/^[a-f0-9]{64}$/', $token)) {
            return null;
        }
        return $this->queryOne(
            "SELECT * FROM usuario WHERE token_verificacao = ? AND email_verificado = FALSE LIMIT 1",
            [hash('sha256', $token)]
        );
    }

    /**
     * Cria usuário. $dados['senha'] deve vir JÁ com hash (PasswordHelper::hash).
     */
    public function create(array $dados): int
    {
        $dados = $this->filtrar($dados) + [
            'id_perfil' => Perfil::USUARIO,
            'email_verificado' => 0,
            'ativo' => 1,
        ];
        return $this->insert($dados);
    }

    public function update($id, array $dados): bool
    {
        return parent::update($id, $this->filtrar($dados));
    }

    public function updatePassword(int $id, string $senhaHash): bool
    {
        return $this->update($id, ['senha' => $senhaHash]);
    }

    public function verificarEmail(int $id): bool
    {
        return $this->execute(
            "UPDATE usuario SET email_verificado = TRUE, token_verificacao = NULL, data_verificacao = NOW() WHERE id_usuario = ?",
            [$id]
        ) > 0;
    }

    public function emailExists(string $email, ?int $excluirId = null): bool
    {
        $sql = "SELECT 1 FROM usuario WHERE email = ?";
        $params = [trim($email)];
        if ($excluirId !== null) {
            $sql .= " AND id_usuario <> ?";
            $params[] = $excluirId;
        }
        return $this->queryOne($sql . ' LIMIT 1', $params) !== null;
    }

    /** Gera token de verificação: grava o hash e devolve o token puro (vai no e-mail). */
    public function gerarTokenVerificacao(int $id): string
    {
        $token = bin2hex(random_bytes(32));
        $this->update($id, ['token_verificacao' => hash('sha256', $token)]);
        return $token;
    }

    /** Lista com nome do perfil. */
    public function listar(bool $somenteAtivos = false): array
    {
        $where = $somenteAtivos ? 'WHERE u.ativo = TRUE' : '';
        return $this->query(
            "SELECT u.*, p.perfil AS nome_perfil
             FROM usuario u LEFT JOIN perfil p ON p.id_perfil = u.id_perfil
             {$where} ORDER BY u.nome ASC"
        );
    }

    /** Mantido por compatibilidade: só ativos. */
    public function getAll(): array
    {
        return $this->listar(true);
    }

    public function getWithPagination(int $limite, int $offset): array
    {
        return $this->query(
            "SELECT u.*, p.perfil AS nome_perfil
             FROM usuario u LEFT JOIN perfil p ON p.id_perfil = u.id_perfil
             ORDER BY u.nome ASC LIMIT ? OFFSET ?",
            [$limite, $offset]
        );
    }

    public function getTotal(): int
    {
        return $this->count();
    }

    public function getTotalAtivos(): int
    {
        return $this->count(['ativo' => 1]);
    }

    public function getCountByPerfil(): array
    {
        return $this->query(
            "SELECT p.id_perfil, p.perfil, COUNT(u.id_usuario) AS total
             FROM perfil p LEFT JOIN usuario u ON u.id_perfil = p.id_perfil
             GROUP BY p.id_perfil, p.perfil ORDER BY p.id_perfil"
        );
    }

    public function atualizarPerfil(int $idUsuario, int $idPerfil): bool
    {
        return $this->update($idUsuario, ['id_perfil' => $idPerfil]);
    }

    public function getPerfis(): array
    {
        return (new Perfil())->all('id_perfil');
    }

    private function filtrar(array $dados): array
    {
        $dados = array_intersect_key($dados, array_flip(self::COLUNAS));
        foreach (['telefone', 'data_nascimento'] as $opcional) {
            if (array_key_exists($opcional, $dados) && $dados[$opcional] === '') {
                $dados[$opcional] = null;
            }
        }
        foreach (['ativo', 'email_verificado'] as $bool) {
            if (array_key_exists($bool, $dados)) {
                $dados[$bool] = $dados[$bool] ? 1 : 0;
            }
        }
        return $dados;
    }
}
