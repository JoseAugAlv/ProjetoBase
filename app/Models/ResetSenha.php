<?php
// app/Models/ResetSenha.php — tabela `reset_senha`
// O token puro só existe no e-mail; o banco guarda o hash sha256.

class ResetSenha extends Model
{
    protected $table = 'reset_senha';
    protected $primaryKey = 'id_reset';

    /**
     * Cria um token novo (invalida os anteriores do usuário) e devolve o token puro.
     */
    public function criar(int $idUsuario, int $validadeMinutos = 60): string
    {
        $this->execute("UPDATE reset_senha SET usado = TRUE WHERE id_usuario = ? AND usado = FALSE", [$idUsuario]);

        $token = bin2hex(random_bytes(32));
        // Expiração calculada no MySQL para não depender do fuso do PHP
        $this->execute(
            "INSERT INTO reset_senha (id_usuario, token, expiracao) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL ? MINUTE))",
            [$idUsuario, hash('sha256', $token), $validadeMinutos]
        );
        return $token;
    }

    /** Retorna o registro se o token for válido (não usado e não expirado). */
    public function validar(string $token): ?array
    {
        if (!preg_match('/^[a-f0-9]{64}$/', $token)) {
            return null;
        }
        return $this->queryOne(
            "SELECT * FROM reset_senha WHERE token = ? AND usado = FALSE AND expiracao > NOW() LIMIT 1",
            [hash('sha256', $token)]
        );
    }

    public function marcarUsado(string $token): void
    {
        $this->execute("UPDATE reset_senha SET usado = TRUE WHERE token = ?", [hash('sha256', $token)]);
    }

    /** Limpa tokens velhos (pode rodar de vez em quando). */
    public function limparExpirados(): int
    {
        return $this->execute("DELETE FROM reset_senha WHERE expiracao < NOW() - INTERVAL 7 DAY");
    }
}
