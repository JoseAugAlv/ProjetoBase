<?php
// app/Models/Usuario.php

require_once __DIR__ . '/../Config/database.php';

class Usuario
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    /**
     * Busca usuário por email
     */
    public function findByEmail(string $email): ?array
    {
        $sql = "SELECT * FROM usuario WHERE email = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ?: null;
    }

    /**
     * Busca usuário por ID
     */
    public function findById(int $id): ?array
    {
        $sql = "SELECT u.*, p.perfil as nome_perfil 
                FROM usuario u
                LEFT JOIN perfil p ON u.id_perfil = p.id_perfil
                WHERE u.id_usuario = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ?: null;
    }

    /**
     * Busca usuário por token de verificação
     */
    public function findByToken(string $token): ?array
    {
        $sql = "SELECT * FROM usuario WHERE token_verificacao = ? AND email_verificado = FALSE";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$token]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ?: null;
    }

    /**
     * Busca o perfil do usuário
     */
    public function getPerfil(int $idUsuario): int
    {
        $sql = "SELECT id_perfil FROM usuario WHERE id_usuario = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idUsuario]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ? (int) $resultado['id_perfil'] : 4;
    }

    /**
     * Cria um novo usuário
     */
    public function create(array $dados): int
    {
        // ============================================================
        // REMOVIDO: primeiro_acesso = TRUE
        // Agora o campo primeiro_acesso sempre será FALSE
        // ============================================================
        $sql = "INSERT INTO usuario (
                    nome, 
                    email, 
                    senha, 
                    telefone, 
                    data_nascimento, 
                    id_perfil, 
                    token_verificacao, 
                    email_verificado,
                    primeiro_acesso
                ) VALUES (?, ?, ?, ?, ?, ?, ?, FALSE, ?)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            $dados['nome'],
            $dados['email'],
            $dados['senha'],
            $dados['telefone'] ?? null,
            $dados['data_nascimento'] ?? null,
            $dados['id_perfil'] ?? 4,
            $dados['token'],
            $dados['primeiro_acesso'] ?? false // <-- Agora FALSE por padrão
        ]);
        return (int) $this->conn->lastInsertId();
    }

    /**
     * Atualiza dados do usuário
     */
    public function update(int $id, array $dados): bool
    {
        $sql = "UPDATE usuario SET ";
        $params = [];
        $updates = [];

        if (isset($dados['nome'])) {
            $updates[] = "nome = ?";
            $params[] = $dados['nome'];
        }
        if (isset($dados['email'])) {
            $updates[] = "email = ?";
            $params[] = $dados['email'];
        }
        if (isset($dados['senha'])) {
            $updates[] = "senha = ?";
            $params[] = $dados['senha'];
        }
        if (isset($dados['telefone'])) {
            $updates[] = "telefone = ?";
            $params[] = $dados['telefone'];
        }
        if (isset($dados['data_nascimento'])) {
            $updates[] = "data_nascimento = ?";
            $params[] = $dados['data_nascimento'];
        }
        if (isset($dados['id_perfil'])) {
            $updates[] = "id_perfil = ?";
            $params[] = $dados['id_perfil'];
        }
        if (isset($dados['token_verificacao'])) {
            $updates[] = "token_verificacao = ?";
            $params[] = $dados['token_verificacao'];
        }
        if (isset($dados['email_verificado'])) {
            $updates[] = "email_verificado = ?";
            $params[] = $dados['email_verificado'];
        }
        // ============================================================
        // REMOVIDO: primeiro_acesso não é mais atualizado
        // ============================================================
        if (isset($dados['ativo'])) {
            $updates[] = "ativo = ?";
            $params[] = $dados['ativo'];
        }

        if (empty($updates)) {
            return false;
        }

        $sql .= implode(', ', $updates) . " WHERE id_usuario = ?";
        $params[] = $id;

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Atualiza a senha do usuário
     */
    public function updatePassword(int $id, string $senhaHash): bool
    {
        $sql = "UPDATE usuario SET senha = ? WHERE id_usuario = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$senhaHash, $id]);
    }

    /**
     * Verifica o email do usuário
     */
    public function verificarEmail(int $idUsuario): bool
    {
        $sql = "UPDATE usuario 
                SET email_verificado = TRUE, 
                    token_verificacao = NULL, 
                    data_verificacao = NOW() 
                WHERE id_usuario = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$idUsuario]);
    }

    /**
     * Verifica se o email já está em uso (exceto o próprio usuário)
     */
    public function emailExists(string $email, ?int $excluirId = null): bool
    {
        $sql = "SELECT id_usuario FROM usuario WHERE email = ?";
        $params = [$email];
        
        if ($excluirId !== null) {
            $sql .= " AND id_usuario != ?";
            $params[] = $excluirId;
        }
        
        $sql .= " LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return (bool) $stmt->fetch();
    }

    /**
     * Gera e salva token de verificação
     */
    public function gerarTokenVerificacao(int $idUsuario): string
    {
        $token = bin2hex(random_bytes(32));
        $sql = "UPDATE usuario SET token_verificacao = ? WHERE id_usuario = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$token, $idUsuario]);
        return $token;
    }

    /**
     * Verifica se o token de redefinição é válido
     */
    public function validarTokenReset(string $token): ?array
    {
        $sql = "SELECT * FROM reset_senha 
                WHERE usado = FALSE AND expiracao > NOW()";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $tokens = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($tokens as $row) {
            if (hash_equals($row['token'], $token)) {
                return ['id_usuario' => $row['id_usuario']];
            }
        }
        
        return null;
    }

    /**
     * Salva token de redefinição de senha
     */
    public function salvarTokenReset(int $idUsuario, string $token): bool
    {
        $expiracao = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $sql = "INSERT INTO reset_senha (id_usuario, token, expiracao) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$idUsuario, $token, $expiracao]);
    }

    /**
     * Marca token de redefinição como usado
     */
    public function marcarTokenResetUsado(string $token): bool
    {
        $sql = "UPDATE reset_senha SET usado = TRUE WHERE token = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$token]);
    }

    /**
     * Busca todos os usuários
     */
    public function getAll(): array
    {
        $sql = "SELECT u.*, p.perfil as nome_perfil 
                FROM usuario u
                LEFT JOIN perfil p ON u.id_perfil = p.id_perfil
                WHERE u.ativo = TRUE
                ORDER BY u.nome ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca usuários com paginação
     */
    public function getWithPagination(int $limite, int $offset): array
    {
        $sql = "SELECT u.*, p.perfil as nome_perfil 
                FROM usuario u
                LEFT JOIN perfil p ON u.id_perfil = p.id_perfil
                ORDER BY u.nome ASC
                LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$limite, $offset]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Total de usuários
     */
    public function getTotal(): int
    {
        $sql = "SELECT COUNT(*) as total FROM usuario";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) ($resultado['total'] ?? 0);
    }

    /**
     * Total de usuários ativos
     */
    public function getTotalAtivos(): int
    {
        $sql = "SELECT COUNT(*) as total FROM usuario WHERE ativo = TRUE";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) ($resultado['total'] ?? 0);
    }

    /**
     * Usuários agrupados por perfil
     */
    public function getCountByPerfil(): array
    {
        $sql = "SELECT p.perfil, COUNT(*) as total 
                FROM usuario u
                INNER JOIN perfil p ON u.id_perfil = p.id_perfil
                GROUP BY p.perfil
                ORDER BY p.id_perfil";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Atualiza o perfil do usuário
     */
    public function atualizarPerfil(int $idUsuario, int $idPerfil): bool
    {
        $sql = "UPDATE usuario SET id_perfil = ? WHERE id_usuario = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$idPerfil, $idUsuario]);
    }

    /**
     * Busca perfis disponíveis
     */
    public function getPerfis(): array
    {
        $sql = "SELECT * FROM perfil ORDER BY id_perfil";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca perfil por ID
     */
    public function getPerfilById(int $idPerfil): ?array
    {
        $sql = "SELECT * FROM perfil WHERE id_perfil = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idPerfil]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ?: null;
    }

    // ============================================================
    // REMOVIDO: Métodos relacionados a primeiro acesso
    // - getPrimeiroAcessoPendentes()
    // - contarPrimeiroAcessoPendentes()
    // - concluirPrimeiroAcesso()
    // - resetarSenhaPrimeiroAcesso()
    // ============================================================
}