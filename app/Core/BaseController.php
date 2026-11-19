<?php
// app/Core/BaseController.php
// Classe mãe de todos os controllers. Um controller por página/área:
// recebe a requisição, chama os models e entrega os dados para a view.
//
// Permissão por perfil fica na ROTA (routes/web.php). Use requireRole() aqui
// só para regras extras dentro de um método.

abstract class BaseController
{
    /** Renderiza app/Views/{$view}.php com as variáveis de $dados. */
    protected function view(string $view, array $dados = []): void
    {
        View::render($view, $dados);
    }

    protected function redirect(string $caminho): void
    {
        redirect($caminho);
    }

    protected function back(string $fallback = '/'): void
    {
        back($fallback);
    }

    protected function flash(string $tipo, string $mensagem, ?array $acao = null): void
    {
        flash($tipo, $mensagem, $acao);
    }

    /** Atalho: grava mensagem flash e redireciona. */
    protected function redirectWith(string $caminho, string $tipo, string $mensagem): void
    {
        flash($tipo, $mensagem);
        redirect($caminho);
    }

    protected function json($dados, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($dados, JSON_UNESCAPED_UNICODE);
        exit;
    }

    protected function abort(int $codigo): void
    {
        View::erro($codigo);
    }

    protected function requireLogin(): void
    {
        if (!Auth::check()) {
            redirect('/login');
        }
    }

    protected function requireRole(array $roles): void
    {
        $this->requireLogin();
        if (!Auth::hasRole($roles)) {
            View::erro(403);
        }
    }

    /** Lê um campo de POST/GET já com trim. */
    protected function input(string $chave, $padrao = '')
    {
        $valor = $_POST[$chave] ?? $_GET[$chave] ?? $padrao;
        return is_string($valor) ? trim($valor) : $valor;
    }

    protected function inputInt(string $chave, int $padrao = 0): int
    {
        return (int) ($this->input($chave, $padrao));
    }

    /** Registra ação na auditoria (arquivo logs/auditoria.log + tabela log_sistema). */
    protected function log(string $acao, string $detalhes = '', ?string $tabela = null, ?int $registroId = null, string $tipo = 'info'): void
    {
        SecurityHelper::logAuditoria($acao, Auth::id(), $detalhes, $tipo, $tabela, $registroId);
    }
}
