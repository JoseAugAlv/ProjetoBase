<?php
// app/Models/LogSistema.php — tabela `log_sistema` (auditoria)
// Gravação normalmente via SecurityHelper::logAuditoria() ou $this->log() no controller.

class LogSistema extends Model
{
    protected $table = 'log_sistema';
    protected $primaryKey = 'id_log';

    public function registrar(string $acao, ?string $tabela = null, ?int $registroId = null, string $detalhes = '', ?int $idUsuario = null, ?string $ip = null): int
    {
        return $this->insert([
            'acao' => mb_substr($acao, 0, 100),
            'tabela_afetada' => $tabela,
            'registro_id' => $registroId,
            'detalhes' => $detalhes,
            'id_usuario' => $idUsuario,
            'ip' => $ip,
        ]);
    }

    /**
     * Logs com filtros opcionais: ['buscar' => '', 'tabela' => '', 'acao' => '']
     */
    public function getWithFilters(int $limite, int $offset, array $filtros = []): array
    {
        [$where, $params] = $this->filtrosSql($filtros, 'l.');
        $params[] = $limite;
        $params[] = $offset;

        return $this->query(
            "SELECT l.*, u.nome AS usuario_nome
             FROM log_sistema l LEFT JOIN usuario u ON u.id_usuario = l.id_usuario
             {$where} ORDER BY l.data_criacao DESC, l.id_log DESC LIMIT ? OFFSET ?",
            $params
        );
    }

    public function getTotalWithFilters(array $filtros = []): int
    {
        [$where, $params] = $this->filtrosSql($filtros, '');
        $row = $this->queryOne("SELECT COUNT(*) AS total FROM log_sistema {$where}", $params);
        return (int) ($row['total'] ?? 0);
    }

    public function getWithPagination(int $limite, int $offset): array
    {
        return $this->getWithFilters($limite, $offset);
    }

    public function getTotal(): int
    {
        return $this->count();
    }

    public function getTabelas(): array
    {
        return array_column($this->query(
            "SELECT DISTINCT tabela_afetada FROM log_sistema WHERE tabela_afetada IS NOT NULL AND tabela_afetada <> '' ORDER BY tabela_afetada"
        ), 'tabela_afetada');
    }

    public function getAcoes(): array
    {
        return array_column($this->query("SELECT DISTINCT acao FROM log_sistema ORDER BY acao"), 'acao');
    }

    private function filtrosSql(array $filtros, string $prefixo): array
    {
        $partes = [];
        $params = [];

        if (!empty($filtros['buscar'])) {
            $partes[] = "({$prefixo}acao LIKE ? OR {$prefixo}tabela_afetada LIKE ? OR {$prefixo}detalhes LIKE ?)";
            $termo = '%' . $filtros['buscar'] . '%';
            array_push($params, $termo, $termo, $termo);
        }
        if (!empty($filtros['tabela'])) {
            $partes[] = "{$prefixo}tabela_afetada = ?";
            $params[] = $filtros['tabela'];
        }
        if (!empty($filtros['acao'])) {
            $partes[] = "{$prefixo}acao = ?";
            $params[] = $filtros['acao'];
        }

        return [$partes ? 'WHERE ' . implode(' AND ', $partes) : '', $params];
    }
}
