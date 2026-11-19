<?php
// app/Helpers/functions.php
// Funções globais curtas para controllers e views.

/** Escapa texto para HTML. Use em TODA saída de dado vindo do usuário/banco: <?= e($nome) ?> */
function e($valor): string
{
    return htmlspecialchars((string) ($valor ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** URL interna com o caminho base: url('/usuarios') => /ProjetoBase/usuarios */
function url(string $caminho = '/'): string
{
    return App::getBasePath() . '/' . ltrim($caminho, '/');
}

/** URL de arquivo em public/: asset('css/style.css') */
function asset(string $caminho): string
{
    return App::getBasePath() . '/public/' . ltrim($caminho, '/');
}

function csrf_token(): string
{
    return CsrfMiddleware::generateToken();
}

function csrf_field(): string
{
    return CsrfMiddleware::field();
}

/**
 * Mensagem flash (mostrada uma vez pelo layouts/flash.php).
 * Tipos: sucesso, erro, aviso, info. $acao opcional: ['url' => '...', 'texto' => '...']
 */
function flash(string $tipo, string $mensagem, ?array $acao = null): void
{
    $_SESSION['flash'] = ['tipo' => $tipo, 'mensagem' => $mensagem];
    if ($acao) {
        $_SESSION['flash']['acao'] = $acao;
    }
}

/** Redireciona para um caminho interno ('/usuarios') e encerra. */
function redirect(string $caminho): void
{
    header('Location: ' . url($caminho));
    exit;
}

/** Volta para a página anterior (se for do próprio site) ou para $fallback. */
function back(string $fallback = '/'): void
{
    $ref = $_SERVER['HTTP_REFERER'] ?? '';
    $host = $_SERVER['HTTP_HOST'] ?? '';
    $partes = $ref ? parse_url($ref) : [];
    $refHost = ($partes['host'] ?? '') . (isset($partes['port']) ? ':' . $partes['port'] : '');

    if ($ref && $refHost === $host && strpos($partes['path'] ?? '', App::getBasePath() . '/') === 0) {
        header('Location: ' . $partes['path'] . (isset($partes['query']) ? '?' . $partes['query'] : ''));
        exit;
    }
    redirect($fallback);
}

/** IP do cliente (REMOTE_ADDR; não confia em X-Forwarded-For). */
function client_ip(): string
{
    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}
