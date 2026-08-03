<?php
// app/Controllers/AuthController.php

require_once __DIR__ . '/../Core/App.php';
require_once __DIR__ . '/../Models/Usuario.php';
require_once __DIR__ . '/../Core/Mail.php';

class AuthController
{
    private $usuario;

    public function __construct()
    {
        $this->usuario = new Usuario();
    }

    /**
     * Página de login
     */
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (isset($_SESSION['usuario'])) {
            header('Location: ' . App::getBasePath() . '/');
            exit;
        }
        
        $basePath = App::getBasePath();
        $appName = App::getName();
        require '../app/Views/auth/index.php';
    }

    /**
     * Processar login
     */
    public function login()
    {
        require_once __DIR__ . '/../Middleware/CsrfMiddleware.php';
        CsrfMiddleware::validate();

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $login = trim($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';

        if (empty($login) || empty($senha)) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Preencha todos os campos.'];
            header('Location: ' . App::getBasePath() . '/login');
            exit;
        }

        $usuario = $this->usuario->findByEmail($login);

        if (!$usuario || !password_verify($senha, $usuario['senha'])) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Email ou senha incorretos.'];
            header('Location: ' . App::getBasePath() . '/login');
            exit;
        }

        if (isset($usuario['ativo']) && !$usuario['ativo']) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Usuário inativo.'];
            header('Location: ' . App::getBasePath() . '/login');
            exit;
        }

        if (isset($usuario['email_verificado']) && !$usuario['email_verificado']) {
            $_SESSION['flash'] = [
                'tipo' => 'aviso',
                'mensagem' => 'Confirme seu e-mail. <a href="' . App::getBasePath() . '/auth/re-enviar?email=' . urlencode($usuario['email']) . '">Reenviar verificação</a>'
            ];
            header('Location: ' . App::getBasePath() . '/login');
            exit;
        }

        // ============================================================
        // REMOVIDO: Lógica de primeiro acesso
        // O usuário sempre faz login normalmente
        // ============================================================

        $_SESSION['usuario'] = [
            'id' => $usuario['id_usuario'],
            'nome' => $usuario['nome'],
            'email' => $usuario['email'],
            'role' => (int) $usuario['id_perfil']
        ];

        require_once __DIR__ . '/../Helpers/SecurityHelper.php';
        SecurityHelper::logAuditoria('login_usuario', $usuario['id_usuario'], 'Login realizado', 'info');

        header('Location: ' . App::getBasePath() . '/');
        exit;
    }

    /**
     * Logout
     */
    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_destroy();
        header('Location: ' . App::getBasePath() . '/');
        exit;
    }

    /**
     * Página de cadastro
     */
    public function cadastrar()
    {
        $basePath = App::getBasePath();
        $appName = App::getName();
        require '../app/Views/auth/criar.php';
    }

    /**
     * Processar cadastro
     */
    public function salvar()
    {
        require_once __DIR__ . '/../Middleware/CsrfMiddleware.php';
        CsrfMiddleware::validate();
        
        require_once __DIR__ . '/../Helpers/SecurityHelper.php';

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';
        $senhaConfirm = $_POST['senha_confirm'] ?? '';
        $telefone = trim($_POST['telefone'] ?? '');
        $dataNascimento = $_POST['data_nascimento'] ?? '';

        if (empty($nome) || empty($email) || empty($senha)) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Nome, e-mail e senha são obrigatórios.'];
            header('Location: ' . App::getBasePath() . '/login/cadastrar');
            exit;
        }

        if ($senha !== $senhaConfirm) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'As senhas não coincidem.'];
            header('Location: ' . App::getBasePath() . '/login/cadastrar');
            exit;
        }

        $validacao = SecurityHelper::validarForcaSenha($senha);
        if (!$validacao['valida']) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Senha fraca. Requisitos: ' . implode(', ', $validacao['erros'])];
            header('Location: ' . App::getBasePath() . '/login/cadastrar');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'E-mail inválido.'];
            header('Location: ' . App::getBasePath() . '/login/cadastrar');
            exit;
        }

        if (!empty($dataNascimento)) {
            $idade = date_diff(date_create($dataNascimento), date_create('today'))->y;
            if ($idade < 12) {
                $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Você deve ter pelo menos 12 anos.'];
                header('Location: ' . App::getBasePath() . '/login/cadastrar');
                exit;
            }
        }

        if ($this->usuario->emailExists($email)) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Este e-mail já está cadastrado.'];
            header('Location: ' . App::getBasePath() . '/login/cadastrar');
            exit;
        }

        try {
            $token = bin2hex(random_bytes(32));
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            // ============================================================
            // REMOVIDO: primeiro_acesso = TRUE
            // Agora o usuário já fica com primeiro_acesso = FALSE
            // ============================================================
            $idUsuario = $this->usuario->create([
                'nome' => $nome,
                'email' => $email,
                'senha' => $senhaHash,
                'telefone' => $telefone,
                'data_nascimento' => $dataNascimento,
                'token' => $token,
                'primeiro_acesso' => false // <-- Agora é FALSE
            ]);

            $this->usuario->atualizarPerfil($idUsuario, 4);

            require_once __DIR__ . '/../Helpers/SecurityHelper.php';
            SecurityHelper::logAuditoria('cadastro_usuario', 'system', 'Novo usuário cadastrado: ' . $email . ' | Nome: ' . $nome, 'info');

            $this->enviarEmailVerificacao($nome, $email, $token);

            $_SESSION['flash'] = ['tipo' => 'sucesso', 'mensagem' => 'Cadastro realizado! Um e-mail de verificação foi enviado para ' . $email . '.'];
            header('Location: ' . App::getBasePath() . '/login');
            exit;

        } catch (Exception $e) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Erro ao cadastrar: ' . $e->getMessage()];
            header('Location: ' . App::getBasePath() . '/login/cadastrar');
            exit;
        }
    }

    /**
     * Enviar e-mail de verificação
     */
    private function enviarEmailVerificacao($nome, $email, $token)
    {
        $appName = App::getName();
        $appUrl = App::getUrl();
        $link = $appUrl . '/auth/verificar?token=' . $token;

        $assunto = "Confirme seu e-mail - " . $appName;

        $mensagem = "
        <html>
        <head>
            <style>
                body { font-family: 'Inter', sans-serif; background: #f8fafc; padding: 40px; }
                .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 16px; padding: 40px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
                .header { text-align: center; margin-bottom: 30px; }
                .header h1 { font-family: 'Montserrat', sans-serif; color: #062c21; font-weight: 800; font-size: 28px; }
                .header h1 span { color: #10b981; }
                .content { color: #334155; line-height: 1.8; }
                .btn { display: inline-block; padding: 14px 35px; background: #10b981; color: #ffffff !important; text-decoration: none; border-radius: 8px; font-weight: 700; margin: 20px 0; }
                .btn:hover { background: #059669; }
                .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e9ecef; color: #95a5a6; font-size: 14px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>" . strtoupper($appName) . ".</h1>
                </div>
                <div class='content'>
                    <h2>Olá, " . htmlspecialchars($nome) . "!</h2>
                    <p>Bem-vindo ao <strong>" . $appName . "</strong>! Para começar a usar sua conta, você precisa confirmar seu e-mail.</p>
                    <p>Clique no botão abaixo para verificar seu endereço de e-mail:</p>
                    <p style='text-align: center;'>
                        <a href='" . $link . "' class='btn'>Confirmar E-mail</a>
                    </p>
                    <p>Se você não criou uma conta no " . $appName . ", ignore este e-mail.</p>
                    <p>Este link é válido por 24 horas.</p>
                </div>
                <div class='footer'>
                    <p>&copy; " . date('Y') . " " . $appName . "</p>
                </div>
            </div>
        </body>
        </html>
        ";

        $mail = new Mail();
        $mail->enviar($email, $nome, $assunto, $mensagem);
    }

    /**
     * Verificar e-mail
     */
    public function verificar()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $token = $_GET['token'] ?? '';
        $status = $_GET['status'] ?? '';

        if (!empty($status)) {
            require '../app/Views/auth/verificar.php';
            return;
        }

        if (empty($token)) {
            $_GET['status'] = 'erro';
            $_GET['mensagem'] = 'Token de verificação inválido.';
            require '../app/Views/auth/verificar.php';
            return;
        }

        $usuario = $this->usuario->findByToken($token);

        if (!$usuario) {
            $_GET['status'] = 'erro';
            $_GET['mensagem'] = 'Token inválido ou conta já verificada.';
            require '../app/Views/auth/verificar.php';
            return;
        }

        $this->usuario->verificarEmail($usuario['id_usuario']);

        $_GET['status'] = 'sucesso';
        $_GET['mensagem'] = '';
        require '../app/Views/auth/verificar.php';
    }

    /**
     * Reenviar verificação
     */
    public function reenviarVerificacao()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $email = $_GET['email'] ?? '';

        if (empty($email)) {
            header('Location: ' . App::getBasePath() . '/login');
            exit;
        }

        $usuario = $this->usuario->findByEmail($email);

        if (!$usuario || $usuario['email_verificado']) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Usuário não encontrado ou já verificado.'];
            header('Location: ' . App::getBasePath() . '/login');
            exit;
        }

        $novoToken = $this->usuario->gerarTokenVerificacao($usuario['id_usuario']);
        $this->enviarEmailVerificacao($usuario['nome'], $email, $novoToken);

        $_SESSION['flash'] = ['tipo' => 'sucesso', 'mensagem' => 'E-mail de verificação reenviado!'];
        header('Location: ' . App::getBasePath() . '/login');
        exit;
    }

    /**
     * Página "Esqueci a Senha"
     */
    public function esqueciSenha()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $basePath = App::getBasePath();
        $appName = App::getName();
        require '../app/Views/auth/esqueci_senha.php';
    }

    /**
     * Enviar token de redefinição
     */
    public function enviarToken()
    {
        require_once __DIR__ . '/../Middleware/CsrfMiddleware.php';
        CsrfMiddleware::validate();

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $email = trim($_POST['email'] ?? '');

        if (empty($email)) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Informe seu e-mail.'];
            header('Location: ' . App::getBasePath() . '/auth/esqueci-senha');
            exit;
        }

        $usuario = $this->usuario->findByEmail($email);

        if (!$usuario) {
            $_SESSION['flash'] = ['tipo' => 'sucesso', 'mensagem' => 'Se o e-mail existir, você receberá as instruções.'];
            header('Location: ' . App::getBasePath() . '/login');
            exit;
        }

        $token = bin2hex(random_bytes(32));
        $this->usuario->salvarTokenReset($usuario['id_usuario'], $token);

        try {
            $mail = new Mail();
            $enviado = $mail->sendResetPassword($email, $usuario['nome'], $token);

            if ($enviado) {
                $_SESSION['flash'] = ['tipo' => 'sucesso', 'mensagem' => 'E-mail enviado para ' . $email];
            } else {
                $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Erro ao enviar e-mail.'];
            }
        } catch (Exception $e) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Erro ao enviar e-mail: ' . $e->getMessage()];
        }

        header('Location: ' . App::getBasePath() . '/login');
        exit;
    }

    /**
     * Página de redefinição de senha
     */
    public function redefinir()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $token = $_GET['token'] ?? '';
        $sucesso = $_GET['sucesso'] ?? 0;

        if ($sucesso == 1) {
            require '../app/Views/auth/redefinir_senha.php';
            return;
        }

        if (empty($token)) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Token inválido.'];
            header('Location: ' . App::getBasePath() . '/login');
            exit;
        }

        $reset = $this->usuario->validarTokenReset($token);

        if (!$reset) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Token inválido ou expirado.'];
            header('Location: ' . App::getBasePath() . '/login');
            exit;
        }

        $basePath = App::getBasePath();
        require '../app/Views/auth/redefinir_senha.php';
    }

    /**
     * Processar redefinição de senha
     */
    public function redefinirSenha()
    {
        require_once __DIR__ . '/../Middleware/CsrfMiddleware.php';
        CsrfMiddleware::validate();

        require_once __DIR__ . '/../Helpers/SecurityHelper.php';

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $token = $_POST['token'] ?? '';
        $senha = $_POST['senha'] ?? '';
        $senhaConfirm = $_POST['senha_confirm'] ?? '';

        if (empty($token) || empty($senha) || empty($senhaConfirm)) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Preencha todos os campos.'];
            header('Location: ' . App::getBasePath() . '/auth/redefinir?token=' . $token);
            exit;
        }

        if ($senha !== $senhaConfirm) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'As senhas não coincidem.'];
            header('Location: ' . App::getBasePath() . '/auth/redefinir?token=' . $token);
            exit;
        }

        $validacao = SecurityHelper::validarForcaSenha($senha);
        if (!$validacao['valida']) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Senha fraca. Requisitos: ' . implode(', ', $validacao['erros'])];
            header('Location: ' . App::getBasePath() . '/auth/redefinir?token=' . $token);
            exit;
        }

        $reset = $this->usuario->validarTokenReset($token);

        if (!$reset) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Token inválido ou expirado.'];
            header('Location: ' . App::getBasePath() . '/login');
            exit;
        }

        try {
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
            $this->usuario->updatePassword($reset['id_usuario'], $senhaHash);
            $this->usuario->marcarTokenResetUsado($token);

            $_SESSION['flash'] = ['tipo' => 'sucesso', 'mensagem' => 'Senha redefinida com sucesso!'];
            header('Location: ' . App::getBasePath() . '/auth/redefinir?token=' . $token . '&sucesso=1');
            exit;

        } catch (Exception $e) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Erro ao redefinir senha: ' . $e->getMessage()];
            header('Location: ' . App::getBasePath() . '/auth/redefinir?token=' . $token);
            exit;
        }
    }

    // ============================================================
    // REMOVIDO: TODOS os métodos relacionados a primeiro acesso
    // - primeiroAcesso()
    // - completarPrimeiroAcesso()
    // ============================================================
}