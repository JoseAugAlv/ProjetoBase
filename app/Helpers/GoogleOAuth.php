<?php
// app/Helpers/GoogleOAuth.php
// Login com Google (OAuth 2.0 / OpenID Connect) sem bibliotecas externas.
//
// Configuração (.env):
//   GOOGLE_CLIENT_ID=xxxx.apps.googleusercontent.com
//   GOOGLE_CLIENT_SECRET=xxxx
// No Google Cloud Console (APIs e serviços > Credenciais > ID do cliente OAuth > Aplicativo da Web),
// cadastre o URI de redirecionamento autorizado:  {APP_URL}/auth/google/callback
//
// Segurança: parâmetro `state` (anti-CSRF) + PKCE (S256); o código é trocado servidor-a-servidor
// por HTTPS com verificação de certificado; só aceita e-mail verificado pelo Google.

class GoogleOAuth
{
    private const AUTH_URL = 'https://accounts.google.com/o/oauth2/v2/auth';
    private const TOKEN_URL = 'https://oauth2.googleapis.com/token';
    private const USERINFO_URL = 'https://openidconnect.googleapis.com/v1/userinfo';

    public static function configurado(): bool
    {
        return App::get('GOOGLE_CLIENT_ID', '') !== '' && App::get('GOOGLE_CLIENT_SECRET', '') !== '';
    }

    public static function redirectUri(): string
    {
        return App::getUrl() . '/auth/google/callback';
    }

    /** Gera a URL do Google e guarda state/PKCE na sessão. */
    public static function urlAutorizacao(): string
    {
        $state = bin2hex(random_bytes(16));
        $verifier = rtrim(strtr(base64_encode(random_bytes(48)), '+/', '-_'), '=');
        $challenge = rtrim(strtr(base64_encode(hash('sha256', $verifier, true)), '+/', '-_'), '=');

        $_SESSION['google_oauth'] = ['state' => $state, 'verifier' => $verifier, 'criado' => time()];

        return self::AUTH_URL . '?' . http_build_query([
            'client_id' => App::get('GOOGLE_CLIENT_ID'),
            'redirect_uri' => self::redirectUri(),
            'response_type' => 'code',
            'scope' => 'openid email profile',
            'state' => $state,
            'code_challenge' => $challenge,
            'code_challenge_method' => 'S256',
            'prompt' => 'select_account',
        ]);
    }

    /**
     * Valida o retorno do Google e devolve os dados do usuário:
     * ['sub' => id Google, 'email' => ..., 'nome' => ...]. Lança RuntimeException se algo estiver errado.
     */
    public static function processarRetorno(array $query): array
    {
        $sessao = $_SESSION['google_oauth'] ?? null;
        unset($_SESSION['google_oauth']);

        if (!empty($query['error'])) {
            throw new RuntimeException('Login com Google cancelado.');
        }
        if (!$sessao || empty($query['state']) || !hash_equals($sessao['state'], (string) $query['state'])
            || time() - $sessao['criado'] > 600) {
            throw new RuntimeException('Sessão de login expirada. Tente novamente.');
        }
        if (empty($query['code'])) {
            throw new RuntimeException('Resposta inválida do Google.');
        }

        $token = self::http(self::TOKEN_URL, [
            'code' => (string) $query['code'],
            'client_id' => App::get('GOOGLE_CLIENT_ID'),
            'client_secret' => App::get('GOOGLE_CLIENT_SECRET'),
            'redirect_uri' => self::redirectUri(),
            'grant_type' => 'authorization_code',
            'code_verifier' => $sessao['verifier'],
        ]);
        if (empty($token['access_token'])) {
            throw new RuntimeException('Não foi possível validar o login com o Google.');
        }

        $info = self::http(self::USERINFO_URL, null, $token['access_token']);

        if (empty($info['sub']) || empty($info['email'])) {
            throw new RuntimeException('O Google não retornou os dados da conta.');
        }
        if (empty($info['email_verified'])) {
            throw new RuntimeException('O e-mail desta conta Google não está verificado.');
        }

        return [
            'sub' => (string) $info['sub'],
            'email' => mb_strtolower((string) $info['email']),
            'nome' => trim((string) ($info['name'] ?? '')) ?: strstr((string) $info['email'], '@', true),
        ];
    }

    private static function http(string $url, ?array $post = null, ?string $bearer = null): array
    {
        $ch = curl_init($url);
        $headers = ['Accept: application/json'];
        if ($bearer) {
            $headers[] = 'Authorization: Bearer ' . $bearer;
        }
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_HTTPHEADER => $headers,
        ]);
        if ($post !== null) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        }

        $resposta = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $erro = curl_error($ch);
        curl_close($ch);

        if ($resposta === false) {
            error_log('GoogleOAuth: falha de conexão: ' . $erro);
            throw new RuntimeException('Não foi possível falar com o Google agora.');
        }
        $dados = json_decode($resposta, true);
        if ($status >= 400 || !is_array($dados)) {
            error_log('GoogleOAuth: HTTP ' . $status . ' em ' . $url . ': ' . substr((string) $resposta, 0, 300));
            throw new RuntimeException('O Google recusou a autenticação.');
        }
        return $dados;
    }
}
