<?php
// app/Core/Auth.php
// Usuário logado. Sessão: $_SESSION['usuario'] = ['id', 'nome', 'email', 'role'].

class Auth
{
    /**
     * Faz login: troca o ID da sessão (evita session fixation) e grava o usuário.
     */
    public static function login(array $usuario): void
    {
        session_regenerate_id(true);
        unset($_SESSION['csrf_token']);

        $_SESSION['usuario'] = [
            'id' => (int) $usuario['id_usuario'],
            'nome' => $usuario['nome'],
            'email' => $usuario['email'],
            'role' => (int) $usuario['id_perfil'],
        ];
    }

    public static function logout(): void
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', [
                'expires' => time() - 42000,
                'path' => $p['path'],
                'domain' => $p['domain'],
                'secure' => $p['secure'],
                'httponly' => $p['httponly'],
                'samesite' => $p['samesite'] ?? 'Lax',
            ]);
        }

        session_destroy();
    }

    /**
     * Recarrega perfil/nome/status do banco a cada requisição.
     * Assim, se o usuário for desativado ou trocar de perfil, vale na hora (sem esperar logout).
     */
    public static function sincronizar(): void
    {
        if (empty($_SESSION['usuario']['id'])) {
            return;
        }

        $usuario = (new Usuario())->find((int) $_SESSION['usuario']['id']);

        if (!$usuario || !$usuario['ativo']) {
            self::logout();
            session_start();
            return;
        }

        $_SESSION['usuario']['nome'] = $usuario['nome'];
        $_SESSION['usuario']['email'] = $usuario['email'];
        $_SESSION['usuario']['role'] = (int) $usuario['id_perfil'];
    }

    public static function check(): bool
    {
        return isset($_SESSION['usuario']['id']);
    }

    public static function user(): ?array
    {
        return $_SESSION['usuario'] ?? null;
    }

    public static function id(): ?int
    {
        return isset($_SESSION['usuario']['id']) ? (int) $_SESSION['usuario']['id'] : null;
    }

    public static function role(): ?int
    {
        return isset($_SESSION['usuario']['role']) ? (int) $_SESSION['usuario']['role'] : null;
    }

    public static function hasRole(array $roles): bool
    {
        $role = self::role();
        return $role !== null && in_array($role, array_map('intval', $roles), true);
    }
}
