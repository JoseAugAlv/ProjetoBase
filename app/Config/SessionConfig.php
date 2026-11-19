<?php
// app/Config/SessionConfig.php
// Sessão segura: cookie HttpOnly/SameSite, Secure em HTTPS, modo estrito,
// expiração por inatividade (SESSION_TIMEOUT no .env, em segundos) e troca periódica de ID.

class SessionConfig
{
    public static function configure(): void
    {
        if (session_status() !== PHP_SESSION_NONE) {
            return;
        }

        ini_set('session.use_strict_mode', '1');
        ini_set('session.use_only_cookies', '1');
        ini_set('session.use_trans_sid', '0');

        session_set_cookie_params([
            'lifetime' => 0,                       // cookie de sessão (some ao fechar o navegador)
            'path' => App::getSessionPath(),
            'domain' => '',                        // só o host atual
            'secure' => App::isHttps(),
            'httponly' => true,
            'samesite' => 'Lax',
        ]);

        session_name(App::getSessionName());
        session_start();

        // Expira por inatividade
        $timeout = (int) App::get('SESSION_TIMEOUT', 7200);
        $agora = time();
        if (isset($_SESSION['_ultima_atividade']) && $agora - $_SESSION['_ultima_atividade'] > $timeout) {
            $_SESSION = [];
            session_regenerate_id(true);
        }
        $_SESSION['_ultima_atividade'] = $agora;

        // Troca o ID da sessão a cada 30 min (reduz risco de sequestro de sessão)
        if (!isset($_SESSION['_regenerado_em'])) {
            $_SESSION['_regenerado_em'] = $agora;
        } elseif ($agora - $_SESSION['_regenerado_em'] > 1800) {
            session_regenerate_id(true);
            $_SESSION['_regenerado_em'] = $agora;
        }
    }
}
