<?php
// app/Core/App.php
// Configuração global: lê o .env e expõe helpers de caminho/URL/ambiente.

class App
{
    private static $config = null;

    public static function init(): void
    {
        if (self::$config !== null) {
            return;
        }

        $raiz = dirname(__DIR__, 2);
        $envFile = $raiz . '/.env';

        // Primeira execução: cria o .env a partir do .env.example
        if (!is_file($envFile) && is_file($raiz . '/.env.example')) {
            @copy($raiz . '/.env.example', $envFile);
        }

        self::$config = is_file($envFile) ? self::parseEnv($envFile) : [];

        foreach (self::$config as $key => $value) {
            $_ENV[$key] = $value;
        }
    }

    /**
     * Parser simples de .env (CHAVE=valor). Aceita aspas e comentários com #.
     * Não usa parse_ini_file porque ele quebra com senhas contendo ; ! " $ etc.
     */
    private static function parseEnv(string $arquivo): array
    {
        $dados = [];
        foreach (file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $linha) {
            $linha = trim($linha);
            if ($linha === '' || $linha[0] === '#' || strpos($linha, '=') === false) {
                continue;
            }
            [$chave, $valor] = explode('=', $linha, 2);
            $chave = trim($chave);
            $valor = trim($valor);
            $len = strlen($valor);
            if ($len >= 2 && ($valor[0] === '"' || $valor[0] === "'") && $valor[$len - 1] === $valor[0]) {
                $valor = substr($valor, 1, -1);
            }
            $dados[$chave] = $valor;
        }
        return $dados;
    }

    public static function get(string $key, $default = null)
    {
        self::init();
        $valor = self::$config[$key] ?? $default;
        return $valor === '' && $default !== null ? $default : $valor;
    }

    public static function getName(): string
    {
        return (string) self::get('APP_NAME', 'ProjetoBase');
    }

    /** Ambiente: 'production' ou 'development'. Sem APP_ENV assume produção (mais seguro). */
    public static function env(): string
    {
        return (string) self::get('APP_ENV', 'production');
    }

    public static function isDebug(): bool
    {
        return self::env() !== 'production';
    }

    /** Caminho da aplicação na URL (ex: /ProjetoBase). Vazio quando está na raiz do domínio. */
    public static function getBasePath(): string
    {
        self::init();
        $base = array_key_exists('APP_BASE_PATH', self::$config)
            ? self::$config['APP_BASE_PATH']
            : '/' . self::getName();
        $base = rtrim($base, '/');
        return ($base === '' || $base[0] === '/') ? $base : '/' . $base;
    }

    public static function getUrl(): string
    {
        return rtrim((string) self::get('APP_URL', 'http://localhost' . self::getBasePath()), '/');
    }

    public static function isHttps(): bool
    {
        if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
            return true;
        }
        if (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https') {
            return true;
        }
        return strpos(self::getUrl(), 'https://') === 0;
    }

    public static function getSessionName(): string
    {
        return preg_replace('/[^A-Z0-9_]/', '_', strtoupper(self::getName())) . '_SESSION';
    }

    public static function getSessionPath(): string
    {
        return self::getBasePath() ?: '/';
    }

    public static function getAll(): array
    {
        self::init();
        return self::$config;
    }
}
