<?php
// public/index.php — ponto de entrada único de todas as requisições.

require_once __DIR__ . '/../app/bootstrap.php';

// Buffer de saída: permite trocar a página por uma tela de erro limpa se algo falhar no meio
ob_start();

// Sessão segura + usuário logado sincronizado com o banco
SessionConfig::configure();
Auth::sincronizar();

// Headers de segurança
header('X-Frame-Options: DENY');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: strict-origin-when-cross-origin');
header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
header("Content-Security-Policy: frame-ancestors 'none'; base-uri 'self'; form-action 'self'; object-src 'none'");
if (App::isHttps()) {
    header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
}

$router = new Router();
require_once ROOT_PATH . '/routes/web.php';

$router->dispatch($_SERVER['REQUEST_URI'] ?? '/');
