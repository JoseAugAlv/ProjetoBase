<?php
// app/Core/Database.php
// Conexão PDO única (singleton) com o MySQL configurado no .env.

class Database
{
    private static $connection = null;

    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            $host = App::get('DB_HOST', '127.0.0.1');
            $port = App::get('DB_PORT', '3306');
            $dbname = App::get('DB_NAME', 'projetobase');

            // DB_HOST pode vir com a porta junto (127.0.0.1:3307)
            $dsn = strpos($host, ':') !== false
                ? "mysql:host={$host};dbname={$dbname};charset=utf8mb4"
                : "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";

            try {
                self::$connection = new PDO($dsn, App::get('DB_USER', 'root'), App::get('DB_PASS', ''), [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
            } catch (PDOException $e) {
                // Não repassa a mensagem original (pode conter host/usuário)
                error_log('Erro de conexão com o banco: ' . $e->getMessage());
                throw new RuntimeException('Não foi possível conectar ao banco de dados.');
            }
        }

        return self::$connection;
    }

    public static function closeConnection(): void
    {
        self::$connection = null;
    }

    public static function testConnection(): bool
    {
        try {
            self::getConnection();
            return true;
        } catch (Throwable $e) {
            return false;
        }
    }
}
