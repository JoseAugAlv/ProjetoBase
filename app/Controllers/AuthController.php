<?php
// app/Controllers/AuthController.php
// Login, logout, cadastro, verificação de e-mail e recuperação de senha.

class AuthController extends BaseController
{
    private $usuario;

    public function __construct()
    {
        $this->usuario = new Usuario();
    }

    // ------------------------------------------------------------
    // LOGIN / LOGOUT
    // ------------------------------------------------------------

    public function index()
    {
        if (Auth::check()) {
            $this->redirect('/');
        }
        $this->view('auth/index');
    }

    public function login()
    {
        $email = mb_strtolower($this->input('email'));
        $senha = (string) ($_POST['senha'] ?? '');

        if ($email === '' || $senha === '') {
            $this->redirectWith('/login', 'erro', 'Preencha todos os campos.');
        }

        // Limite: 5 tentativas por e-mail+IP e 20 por IP a cada 15 min
        $chaveEmail = 'login:' . $email;
        if (!RateLimiter::check($chaveEmail, 5, 900) || !RateLimiter::check('login-ip', 20, 900)) {
            $minutos = (int) ceil(max(RateLimiter::availableIn($chaveEmail), RateLimiter::availableIn('login-ip')) / 60);
            $this->redirectWith('/login', 'erro', "Muitas tentativas. Tente novamente em {$minutos} minuto(s).");
        }

        $usuario = $this->usuario->findByEmail($email);

        // Sempre roda password_verify (mesmo sem usuário) para não revelar por tempo de resposta se o e-mail existe
        $hash = $usuario['senha'] ?? '$2y$10$20ZaMczcK31C3aqZdVQzw./5SzJQrvglt039hAaF/U9pJZ2G837wi';
        $senhaOk = password_verify($senha, $hash);

        if (!$usuario || !$senhaOk) {
            RateLimiter::increment($chaveEmail, 900);
            RateLimiter::increment('login-ip', 900);
            SecurityHelper::logAuditoria('login_falhou', null, 'E-mail: ' . $email, 'warning');
            $this->redirectWith('/login', 'erro', 'E-mail ou senha incorretos.');
        }

        if (!$usuario['ativo']) {
            $this->redirectWith('/login', 'erro', 'Usuário inativo. Fale com o administrador.');
        }

        if (!$usuario['email_verificado']) {
            $this->flash('aviso', 'Confirme seu e-mail antes de entrar.', [
                'url' => url('/auth/re-enviar?email=' . urlencode($usuario['email'])),
                'texto' => 'Reenviar e-mail de verificação',
            ]);
            $this->redirect('/login');
        }

        // Atualiza o hash se o PHP passou a usar um algoritmo/custo melhor
        if (password_needs_rehash($usuario['senha'], PASSWORD_DEFAULT)) {
            $this->usuario->updatePassword((int) $usuario['id_usuario'], PasswordHelper::hash($senha));
        }

        RateLimiter::reset($chaveEmail);
        Auth::login($usuario);
        $this->log('login', 'Login realizado', 'usuario', (int) $usuario['id_usuario']);

        // Volta para a página que a pessoa tentou abrir antes do login
        $destino = $_SESSION['url_pretendida'] ?? '/';
        unset($_SESSION['url_pretendida']);
        $this->redirect(preg_match('#^/[a-zA-Z0-9/_\-]*$#', $destino) ? $destino : '/');
    }

    // ------------------------------------------------------------
    // LOGIN COM GOOGLE (configure GOOGLE_CLIENT_ID/SECRET no .env)
    // ------------------------------------------------------------

    public function google()
    {
        if (!MenuHelper::isModuleEnabled('login_google')) {
            $this->abort(404);
        }
        if (!GoogleOAuth::configurado()) {
            error_log('Login com Google: GOOGLE_CLIENT_ID/GOOGLE_CLIENT_SECRET não configurados no .env');
            $this->redirectWith('/login', 'aviso', App::isDebug()
                ? 'Login com Google ainda não configurado: preencha GOOGLE_CLIENT_ID e GOOGLE_CLIENT_SECRET no .env.'
                : 'Login com Google indisponível no momento. Entre com e-mail e senha.');
        }
        if (Auth::check()) {
            $this->redirect('/');
        }
        header('Location: ' . GoogleOAuth::urlAutorizacao());
        exit;
    }

    public function googleCallback()
    {
        if (!MenuHelper::isModuleEnabled('login_google') || !GoogleOAuth::configurado()) {
            $this->abort(404);
        }

        try {
            $google = GoogleOAuth::processarRetorno($_GET);
        } catch (RuntimeException $e) {
            $this->redirectWith('/login', 'erro', $e->getMessage());
        }

        // 1) Já vinculado  2) Mesmo e-mail (Google confirmou que é dele) -> vincula  3) Conta nova
        $usuario = $this->usuario->findBy('google_id', $google['sub']) ?? $this->usuario->findByEmail($google['email']);

        if ($usuario) {
            if (!$usuario['ativo']) {
                $this->redirectWith('/login', 'erro', 'Usuário inativo. Fale com o administrador.');
            }
            if ($usuario['google_id'] !== $google['sub']) {
                $this->usuario->update((int) $usuario['id_usuario'], ['google_id' => $google['sub'], 'email_verificado' => 1]);
                $this->log('google_vinculado', 'Conta vinculada ao Google', 'usuario', (int) $usuario['id_usuario']);
            } elseif (!$usuario['email_verificado']) {
                $this->usuario->update((int) $usuario['id_usuario'], ['email_verificado' => 1]);
            }
        } else {
            $id = $this->usuario->create([
                'nome' => mb_substr($google['nome'], 0, 150),
                'email' => $google['email'],
                // Senha aleatória: quem entra pelo Google pode criar uma senha depois em "Esqueci minha senha"
                'senha' => PasswordHelper::hash(PasswordHelper::generateTemp(32)),
                'id_perfil' => Perfil::USUARIO,
                'email_verificado' => 1,
                'google_id' => $google['sub'],
            ]);
            SecurityHelper::logAuditoria('cadastro_google', $id, 'Novo usuário via Google: ' . $google['email'], 'info', 'usuario', $id);
            $usuario = $this->usuario->find($id);
        }

        Auth::login($usuario);
        $this->log('login_google', 'Login com Google', 'usuario', (int) $usuario['id_usuario']);

        $destino = $_SESSION['url_pretendida'] ?? '/';
        unset($_SESSION['url_pretendida']);
        $this->redirect(preg_match('#^/[a-zA-Z0-9/_\-]*$#', $destino) ? $destino : '/');
    }

    /** GET /logout?_token=... (o token impede que outro site deslogue o usuário). */
    public function logout()
    {
        if (Auth::check() && CsrfMiddleware::check($_GET['_token'] ?? null)) {
            $this->log('logout', 'Logout realizado', 'usuario', Auth::id());
            Auth::logout();
        }
        $this->redirect('/');
    }

    // ------------------------------------------------------------
    // CADASTRO E VERIFICAÇÃO DE E-MAIL
    // ------------------------------------------------------------

    public function cadastrar()
    {
        if (Auth::check()) {
            $this->redirect('/');
        }
        $this->view('auth/criar');
    }

    public function salvar()
    {
        $nome = $this->input('nome');
        $email = mb_strtolower($this->input('email'));
        $senha = (string) ($_POST['senha'] ?? '');
        $senhaConfirm = (string) ($_POST['senha_confirm'] ?? '');
        $telefone = $this->input('telefone');
        $dataNascimento = $this->input('data_nascimento');

        if (!RateLimiter::check('cadastro', 5, 3600)) {
            $this->redirectWith('/login/cadastrar', 'erro', 'Muitos cadastros a partir desta rede. Tente mais tarde.');
        }

        $erro = Usuario::validarDados($nome, $email, $telefone, $dataNascimento);
        if (!$erro && $senha !== $senhaConfirm) {
            $erro = 'As senhas não coincidem.';
        }
        if (!$erro) {
            $v = PasswordHelper::validate($senha);
            $erro = $v['valid'] ? null : 'Senha fraca: ' . implode(', ', $v['errors']) . '.';
        }
        if ($erro) {
            $this->redirectWith('/login/cadastrar', 'erro', $erro);
        }

        RateLimiter::increment('cadastro', 3600);

        // Mesmo resultado para e-mail novo ou já cadastrado (não revela quem tem conta)
        $mensagem = 'Cadastro recebido! Enviamos um link de confirmação para ' . $email . '.';

        if ($this->usuario->emailExists($email)) {
            SecurityHelper::logAuditoria('cadastro_email_existente', null, 'E-mail: ' . $email, 'warning');
            $this->redirectWith('/login', 'sucesso', $mensagem);
        }

        $id = $this->usuario->create([
            'nome' => $nome,
            'email' => $email,
            'senha' => PasswordHelper::hash($senha),
            'telefone' => $telefone,
            'data_nascimento' => $dataNascimento,
            'id_perfil' => Perfil::USUARIO,
        ]);

        $token = $this->usuario->gerarTokenVerificacao($id);
        if (!(new Mail())->sendVerificacao($email, $nome, $token)) {
            $mensagem = 'Cadastro realizado, mas não foi possível enviar o e-mail de confirmação agora. Use "Reenviar" na tela de login mais tarde.';
        }

        SecurityHelper::logAuditoria('cadastro_usuario', $id, 'Novo usuário: ' . $email, 'info', 'usuario', $id);
        $this->redirectWith('/login', 'sucesso', $mensagem);
    }

    public function verificar()
    {
        $usuario = $this->usuario->findByTokenVerificacao((string) ($_GET['token'] ?? ''));

        if (!$usuario) {
            $this->view('auth/verificar', ['status' => 'erro', 'mensagem' => 'Link inválido ou conta já verificada.']);
            return;
        }

        $this->usuario->verificarEmail((int) $usuario['id_usuario']);
        SecurityHelper::logAuditoria('email_verificado', $usuario['id_usuario'], '', 'info', 'usuario', (int) $usuario['id_usuario']);
        $this->view('auth/verificar', ['status' => 'sucesso', 'mensagem' => '']);
    }

    public function reenviarVerificacao()
    {
        $email = mb_strtolower(trim((string) ($_GET['email'] ?? '')));

        if ($email !== '' && RateLimiter::check('reenviar:' . $email, 3, 3600)) {
            RateLimiter::increment('reenviar:' . $email, 3600);
            $usuario = $this->usuario->findByEmail($email);
            if ($usuario && !$usuario['email_verificado'] && $usuario['ativo']) {
                $token = $this->usuario->gerarTokenVerificacao((int) $usuario['id_usuario']);
                (new Mail())->sendVerificacao($usuario['email'], $usuario['nome'], $token);
            }
        }

        $this->redirectWith('/login', 'sucesso', 'Se o e-mail estiver cadastrado e pendente, você receberá um novo link.');
    }

    // ------------------------------------------------------------
    // RECUPERAÇÃO DE SENHA
    // ------------------------------------------------------------

    public function esqueciSenha()
    {
        $this->view('auth/esqueci_senha');
    }

    public function enviarToken()
    {
        $email = mb_strtolower($this->input('email'));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->redirectWith('/auth/esqueci-senha', 'erro', 'Informe um e-mail válido.');
        }

        if (RateLimiter::check('reset:' . $email, 3, 3600) && RateLimiter::check('reset-ip', 10, 3600)) {
            RateLimiter::increment('reset:' . $email, 3600);
            RateLimiter::increment('reset-ip', 3600);

            $usuario = $this->usuario->findByEmail($email);
            if ($usuario && $usuario['ativo']) {
                $token = (new ResetSenha())->criar((int) $usuario['id_usuario'], 60);
                (new Mail())->sendResetPassword($usuario['email'], $usuario['nome'], $token);
                SecurityHelper::logAuditoria('reset_senha_solicitado', $usuario['id_usuario'], '', 'info', 'usuario', (int) $usuario['id_usuario']);
            }
        }

        // Mensagem genérica: não revela se o e-mail existe
        $this->redirectWith('/login', 'sucesso', 'Se o e-mail estiver cadastrado, você receberá as instruções em instantes.');
    }

    public function redefinir()
    {
        $token = (string) ($_GET['token'] ?? '');

        if (!(new ResetSenha())->validar($token)) {
            $this->redirectWith('/auth/esqueci-senha', 'erro', 'Link inválido ou expirado. Solicite um novo.');
        }

        $this->view('auth/redefinir_senha', ['token' => $token]);
    }

    public function redefinirSenha()
    {
        $token = (string) ($_POST['token'] ?? '');
        $senha = (string) ($_POST['senha'] ?? '');
        $senhaConfirm = (string) ($_POST['senha_confirm'] ?? '');
        $resetModel = new ResetSenha();

        $reset = $resetModel->validar($token);
        if (!$reset) {
            $this->redirectWith('/auth/esqueci-senha', 'erro', 'Link inválido ou expirado. Solicite um novo.');
        }

        $voltar = '/auth/redefinir?token=' . $token;
        if ($senha !== $senhaConfirm) {
            $this->redirectWith($voltar, 'erro', 'As senhas não coincidem.');
        }
        $v = PasswordHelper::validate($senha);
        if (!$v['valid']) {
            $this->redirectWith($voltar, 'erro', 'Senha fraca: ' . implode(', ', $v['errors']) . '.');
        }

        $idUsuario = (int) $reset['id_usuario'];
        $this->usuario->update($idUsuario, [
            'senha' => PasswordHelper::hash($senha),
            // Quem chegou pelo link do e-mail provou que é dono do endereço
            'email_verificado' => 1,
        ]);
        $resetModel->marcarUsado($token);
        SecurityHelper::logAuditoria('senha_redefinida', $idUsuario, '', 'info', 'usuario', $idUsuario);

        $this->redirectWith('/login', 'sucesso', 'Senha definida com sucesso! Faça login.');
    }
}
