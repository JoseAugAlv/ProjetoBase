<?php
// app/Core/View.php
// Renderiza arquivos de app/Views. As views incluem layouts/header.php,
// layouts/nav.php (menu + mensagens flash) e layouts/footer.php.

class View
{
    /**
     * @param string $view  caminho relativo a app/Views sem .php (ex: 'usuarios/index')
     * @param array  $dados variáveis disponíveis na view
     */
    public static function render(string $view, array $dados = []): void
    {
        if (!preg_match('#^[a-zA-Z0-9_\-/]+$#', $view) || strpos($view, '..') !== false) {
            throw new InvalidArgumentException("Nome de view inválido: {$view}");
        }

        $arquivo = APP_PATH . '/Views/' . $view . '.php';
        if (!is_file($arquivo)) {
            throw new RuntimeException("View não encontrada: {$view}");
        }

        $dados += [
            'basePath' => App::getBasePath(),
            'appName' => App::getName(),
        ];

        (static function () use ($arquivo, $dados) {
            extract($dados, EXTR_SKIP);
            require $arquivo;
        })();
    }

    /**
     * Mostra uma página de erro (403, 404, 419, 500...) e encerra.
     */
    public static function erro(int $codigo, string $detalhe = ''): void
    {
        if (ob_get_level() > 0) {
            while (ob_get_level() > 0) {
                ob_end_clean();
            }
        }
        if (!headers_sent()) {
            http_response_code($codigo);
        }

        if (Router::isAjax()) {
            if (!headers_sent()) {
                header('Content-Type: application/json; charset=utf-8');
            }
            echo json_encode(['erro' => $codigo]);
            exit;
        }

        $mensagens = [
            403 => ['Acesso negado', 'Você não tem permissão para acessar esta página.'],
            404 => ['Página não encontrada', 'O endereço acessado não existe ou foi removido.'],
            419 => ['Sessão expirada', 'Sua sessão expirou. Volte e tente novamente.'],
            500 => ['Erro interno', 'Algo deu errado. Tente novamente em instantes.'],
        ];
        [$titulo, $mensagem] = $mensagens[$codigo] ?? ['Erro', 'Ocorreu um erro.'];

        try {
            self::render('errors/erro', compact('codigo', 'titulo', 'mensagem', 'detalhe'));
        } catch (Throwable $e) {
            // Se até a página de erro falhar (ex: banco fora do ar no nav), mostra o mínimo
            echo '<h1>' . $codigo . ' - ' . htmlspecialchars($titulo) . '</h1><p>' . htmlspecialchars($mensagem) . '</p>';
            if ($detalhe !== '') {
                echo '<pre>' . htmlspecialchars($detalhe) . '</pre>';
            }
        }
        exit;
    }
}
