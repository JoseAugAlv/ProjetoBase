<?php
// app/Middleware/CsrfMiddleware.php
// Proteção CSRF. O Router valida TODO POST automaticamente:
// basta chamar csrf_field() dentro de cada <form method="POST">.
// Para fetch()/AJAX envie o header X-CSRF-TOKEN com csrf_token().

class CsrfMiddleware
{
    public static function generateToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function field(): string
    {
        return '<input type="hidden" name="_csrf_token" value="' . htmlspecialchars(self::generateToken(), ENT_QUOTES, 'UTF-8') . '">';
    }

    /** Confere um token (útil para links GET sensíveis, como o logout). */
    public static function check(?string $token): bool
    {
        $sessao = $_SESSION['csrf_token'] ?? null;
        return $sessao && $token && hash_equals((string) $sessao, (string) $token);
    }

    /**
     * Valida o token da requisição atual. Se inválido: AJAX recebe 419 em JSON;
     * formulário volta para a página anterior com aviso de sessão expirada.
     */
    public static function validate(): void
    {
        $token = $_POST['_csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;

        if (self::check($token)) {
            return;
        }

        if (Router::isAjax()) {
            View::erro(419);
        }

        flash('erro', 'Sua sessão expirou ou o formulário é inválido. Tente novamente.');
        back('/');
    }
}
