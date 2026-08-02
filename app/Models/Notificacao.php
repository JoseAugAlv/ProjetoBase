<?php
require_once __DIR__ . '/../Config/database.php';

class Notificacao
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    /**
     * Busca todas as notificações de um usuário
     */
    public function getByUsuario(int $idUsuario): array
    {
        $sql = "SELECT * FROM notificacao 
                WHERE id_usuario = ? 
                ORDER BY data_criacao DESC 
                LIMIT 100";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idUsuario]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca notificações não lidas de um usuário
     */
    public function getNaoLidas(int $idUsuario): array
    {
        $sql = "SELECT * FROM notificacao 
                WHERE id_usuario = ? AND lida = FALSE 
                ORDER BY data_criacao DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idUsuario]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Conta notificações não lidas
     */
    public function contarNaoLidas(int $idUsuario): int
    {
        $sql = "SELECT COUNT(*) as total FROM notificacao 
                WHERE id_usuario = ? AND lida = FALSE";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$idUsuario]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return (int) $resultado['total'];
    }

    /**
     * Marca uma notificação como lida
     */
    public function marcarComoLida(int $idNotificacao): bool
    {
        $sql = "UPDATE notificacao SET lida = TRUE, data_leitura = NOW() 
                WHERE id_notificacao = ?";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$idNotificacao]);
    }

    /**
     * Marca todas as notificações como lidas
     */
    public function marcarTodasComoLidas(int $idUsuario): bool
    {
        $sql = "UPDATE notificacao SET lida = TRUE, data_leitura = NOW() 
                WHERE id_usuario = ? AND lida = FALSE";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$idUsuario]);
    }
}