<?php
// app/Core/Model.php
// Classe mãe dos models. Um model por tabela:
//
//   class Produto extends Model {
//       protected $table = 'produto';
//       protected $primaryKey = 'id_produto';
//   }
//
// Métodos prontos: all, find, findBy, where, first, count, exists, insert,
// update, delete, paginate, query, queryOne, execute.
// Valores sempre vão por parâmetros preparados; nomes de coluna são validados.

class Model
{
    protected $conn;
    protected $table;
    protected $primaryKey = 'id';

    public function __construct(?string $table = null, ?string $primaryKey = null)
    {
        $this->conn = Database::getConnection();
        if ($table !== null) {
            $this->table = $table;
        }
        if ($primaryKey !== null) {
            $this->primaryKey = $primaryKey;
        }
        self::ident($this->table);
        self::ident($this->primaryKey);
    }

    public function getTable(): string
    {
        return $this->table;
    }

    public function getPrimaryKey(): string
    {
        return $this->primaryKey;
    }

    // ------------------------------------------------------------
    // LEITURA
    // ------------------------------------------------------------

    public function all(?string $orderBy = null): array
    {
        return $this->where([], $orderBy);
    }

    /** Busca pela chave primária. */
    public function find($id): ?array
    {
        return $this->first([$this->primaryKey => $id]);
    }

    public function findBy(string $coluna, $valor): ?array
    {
        return $this->first([$coluna => $valor]);
    }

    /**
     * @param array $conditions ['coluna' => valor] (todas com AND; valor null vira IS NULL)
     */
    public function where(array $conditions = [], ?string $orderBy = null, ?int $limit = null, int $offset = 0): array
    {
        [$whereSql, $params] = $this->buildWhere($conditions);
        $sql = "SELECT * FROM {$this->table}{$whereSql}" . $this->buildOrder($orderBy);

        if ($limit !== null) {
            $sql .= ' LIMIT ' . max(0, $limit) . ' OFFSET ' . max(0, $offset);
        }

        return $this->query($sql, $params);
    }

    public function first(array $conditions = [], ?string $orderBy = null): ?array
    {
        $rows = $this->where($conditions, $orderBy, 1);
        return $rows[0] ?? null;
    }

    public function count(array $conditions = []): int
    {
        [$whereSql, $params] = $this->buildWhere($conditions);
        $row = $this->queryOne("SELECT COUNT(*) AS total FROM {$this->table}{$whereSql}", $params);
        return (int) ($row['total'] ?? 0);
    }

    public function exists(array $conditions): bool
    {
        return $this->count($conditions) > 0;
    }

    /**
     * @return array ['dados' => [...], 'total' => int, 'pagina' => int, 'porPagina' => int, 'totalPaginas' => int]
     */
    public function paginate(int $pagina = 1, int $porPagina = 20, array $conditions = [], ?string $orderBy = null): array
    {
        $total = $this->count($conditions);
        $totalPaginas = max(1, (int) ceil($total / max(1, $porPagina)));
        $pagina = min(max(1, $pagina), $totalPaginas);

        return [
            'dados' => $this->where($conditions, $orderBy, $porPagina, ($pagina - 1) * $porPagina),
            'total' => $total,
            'pagina' => $pagina,
            'porPagina' => $porPagina,
            'totalPaginas' => $totalPaginas,
        ];
    }

    // ------------------------------------------------------------
    // ESCRITA
    // ------------------------------------------------------------

    /** Insere e retorna o ID gerado. */
    public function insert(array $dados): int
    {
        if (empty($dados)) {
            throw new InvalidArgumentException('Nenhum dado para inserir.');
        }
        $colunas = array_keys($dados);
        foreach ($colunas as $coluna) {
            self::ident($coluna);
        }

        $sql = "INSERT INTO {$this->table} (" . implode(', ', $colunas) . ') VALUES ('
            . implode(', ', array_fill(0, count($colunas), '?')) . ')';

        $this->execute($sql, array_values($dados));
        return (int) $this->conn->lastInsertId();
    }

    /** Mantido por compatibilidade: insert() já retorna o ID. */
    public function insertReturnId(array $dados): int
    {
        return $this->insert($dados);
    }

    public function update($id, array $dados): bool
    {
        if (empty($dados)) {
            return false;
        }
        $sets = [];
        foreach (array_keys($dados) as $coluna) {
            self::ident($coluna);
            $sets[] = "{$coluna} = ?";
        }
        $params = array_values($dados);
        $params[] = $id;

        $this->execute("UPDATE {$this->table} SET " . implode(', ', $sets) . " WHERE {$this->primaryKey} = ?", $params);
        return true;
    }

    public function delete($id): bool
    {
        return $this->execute("DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?", [$id]) > 0;
    }

    // ------------------------------------------------------------
    // SQL LIVRE (sempre com parâmetros ? ou :nome)
    // ------------------------------------------------------------

    public function query(string $sql, array $params = []): array
    {
        $stmt = $this->prepareAndBind($sql, $params);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function queryOne(string $sql, array $params = []): ?array
    {
        $stmt = $this->prepareAndBind($sql, $params);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    /** Executa INSERT/UPDATE/DELETE e retorna o número de linhas afetadas. */
    public function execute(string $sql, array $params = []): int
    {
        $stmt = $this->prepareAndBind($sql, $params);
        $stmt->execute();
        return $stmt->rowCount();
    }

    // ------------------------------------------------------------
    // INTERNOS
    // ------------------------------------------------------------

    private function prepareAndBind(string $sql, array $params): PDOStatement
    {
        $stmt = $this->conn->prepare($sql);
        foreach ($params as $chave => $valor) {
            $param = is_int($chave) ? $chave + 1 : (strpos($chave, ':') === 0 ? $chave : ':' . $chave);
            if (is_int($valor)) {
                $tipo = PDO::PARAM_INT;
            } elseif (is_bool($valor)) {
                $tipo = PDO::PARAM_BOOL;
            } elseif ($valor === null) {
                $tipo = PDO::PARAM_NULL;
            } else {
                $tipo = PDO::PARAM_STR;
            }
            $stmt->bindValue($param, $valor, $tipo);
        }
        return $stmt;
    }

    private function buildWhere(array $conditions): array
    {
        if (empty($conditions)) {
            return ['', []];
        }
        $partes = [];
        $params = [];
        foreach ($conditions as $coluna => $valor) {
            self::ident($coluna);
            if ($valor === null) {
                $partes[] = "{$coluna} IS NULL";
            } else {
                $partes[] = "{$coluna} = ?";
                $params[] = $valor;
            }
        }
        return [' WHERE ' . implode(' AND ', $partes), $params];
    }

    /** Aceita "coluna", "coluna DESC", "a ASC, b DESC". */
    private function buildOrder(?string $orderBy): string
    {
        if ($orderBy === null || trim($orderBy) === '') {
            return '';
        }
        if (!preg_match('/^\s*[a-zA-Z_][a-zA-Z0-9_\.]*(\s+(ASC|DESC))?(\s*,\s*[a-zA-Z_][a-zA-Z0-9_\.]*(\s+(ASC|DESC))?)*\s*$/i', $orderBy)) {
            throw new InvalidArgumentException("ORDER BY inválido: {$orderBy}");
        }
        return ' ORDER BY ' . $orderBy;
    }

    /** Garante que um nome de tabela/coluna é seguro para ir direto no SQL. */
    protected static function ident($nome): string
    {
        if (!is_string($nome) || !preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $nome)) {
            throw new InvalidArgumentException('Nome de tabela/coluna inválido: ' . var_export($nome, true));
        }
        return $nome;
    }
}
