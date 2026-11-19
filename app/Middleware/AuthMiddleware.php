<?php
// app/Middleware/AuthMiddleware.php
// Normalmente não é necessário: o Router já exige login nas rotas com perfis.
// Útil se precisar proteger algo fora do Router.

class AuthMiddleware
{
    public static function handle(): void
    {
        if (!Auth::check()) {
            redirect('/login');
        }
    }
}
