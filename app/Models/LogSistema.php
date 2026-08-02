<?php
// app/Models/LogSistema.php

require_once __DIR__ . '/../Config/database.php';

class LogSistema
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    /**
     * Busca logs com paginação
     */
    public function getWithPagination($limite, $offset): array
    {
        $sql = "SELECT 
                    l.*,
                    u.nome as usuario_nome
                FROM log_sistema l
                LEFT JOIN usuario u ON l.id_usuario = u.id_usuario
                ORDER BY l.data_criacao DESC
                LIMIT ? OFFSET ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$limite, $offset]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Total de logs
     */
    public function getTotal(): int
    {
        $sql = "SELECT COUNT(*) as total FROM log_sistema";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) ($resultado['total'] ?? 0);
    }

    /**
     * Lista de tabelas afetadas
     */
    public function getTabelas(): array
    {
        $sql = "SELECT DISTINCT tabela_afetada FROM log_sistema WHERE tabela_afetada IS NOT NULL ORDER BY tabela_afetada";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return array_filter($resultados);
    }

    /**
     * Lista de ações
     */
    public function getAcoes(): array
    {
        $sql = "SELECT DISTINCT acao FROM log_sistema ORDER BY acao";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return array_filter($resultados);
    }

    /**
     * Busca logs com filtros
     */
    public function getWithFilters($limite, $offset, $filtros = []): array
    {
        $sql = "SELECT 
                    l.*,
                    u.nome as usuario_nome
                FROM log_sistema l
                LEFT JOIN usuario u ON l.id_usuario = u.id_usuario
                WHERE 1=1";
        $params = [];

        if (!empty($filtros['buscar'])) {
            $sql .= " AND (l.acao LIKE ? OR l.tabela_afetada LIKE ? OR l.detalhes LIKE ?)";
            $search = '%' . $filtros['buscar'] . '%';
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
        }

        if (!empty($filtros['tabela'])) {
            $sql .= " AND l.tabela_afetada = ?";
            $params[] = $filtros['tabela'];
        }

        if (!empty($filtros['acao'])) {
            $sql .= " AND l.acao = ?";
            $params[] = $filtros['acao'];
        }

        $sql .= " ORDER BY l.data_criacao DESC LIMIT ? OFFSET ?";
        $params[] = $limite;
        $params[] = $offset;

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Total de logs com filtros
     */
    public function getTotalWithFilters($filtros = []): int
    {
        $sql = "SELECT COUNT(*) as total FROM log_sistema WHERE 1=1";
        $params = [];

        if (!empty($filtros['buscar'])) {
            $sql .= " AND (acao LIKE ? OR tabela_afetada LIKE ? OR detalhes LIKE ?)";
            $search = '%' . $filtros['buscar'] . '%';
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
        }

        if (!empty($filtros['tabela'])) {
            $sql .= " AND tabela_afetada = ?";
            $params[] = $filtros['tabela'];
        }

        if (!empty($filtros['acao'])) {
            $sql .= " AND acao = ?";
            $params[] = $filtros['acao'];
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) ($resultado['total'] ?? 0);
    }

    /**
     * Insere um novo log
     */
    public function insert($acao, $tabelaAfetada, $registroId, $detalhes, $idUsuario = null): bool
    {
        $sql = "INSERT INTO log_sistema (acao, tabela_afetada, registro_id, detalhes, id_usuario) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$acao, $tabelaAfetada, $registroId, $detalhes, $idUsuario]);
    }
}