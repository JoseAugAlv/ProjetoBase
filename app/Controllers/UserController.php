<?php
// app/Controllers/UserController.php

require_once __DIR__ . '/../Core/App.php';
require_once __DIR__ . '/../Models/Usuario.php';
require_once __DIR__ . '/../Helpers/PaginationHelper.php';
require_once __DIR__ . '/../Helpers/MenuHelper.php'; // NOVO

class UserController
{
    private $usuario;

    public function __construct()
    {
        $this->usuario = new Usuario();
    }

    public function index()
    {
        if (!isset($_SESSION['usuario'])) {
            header('Location: ' . App::getBasePath() . '/login');
            exit;
        }

        $id = $_SESSION['usuario']['id'];
        $usuario = $this->usuario->findById($id);

        if (!$usuario) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Usuário não encontrado.'];
            header('Location: ' . App::getBasePath() . '/');
            exit;
        }

        // Formata dados
        $usuario['data_nascimento_formatada'] = !empty($usuario['data_nascimento']) 
            ? date('d/m/Y', strtotime($usuario['data_nascimento'])) 
            : 'Não informada';
        
        $usuario['telefone_formatado'] = $usuario['telefone'] ?? 'Não informado';
        $usuario['nome_perfil'] = $usuario['nome_perfil'] ?? 'Usuario';

        $tituloPagina = 'Minha Conta - ' . App::getName();
        $cssPagina = 'user.css';

        require_once __DIR__ . '/../Views/user/index.php';
    }

    public function editar()
    {
        if (!isset($_SESSION['usuario'])) {
            header('Location: ' . App::getBasePath() . '/login');
            exit;
        }

        $id = $_SESSION['usuario']['id'];
        $usuario = $this->usuario->findById($id);

        if (!$usuario) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Usuário não encontrado.'];
            header('Location: ' . App::getBasePath() . '/');
            exit;
        }

        $tituloPagina = 'Editar Conta - ' . App::getName();
        $cssPagina = 'user.css';

        require_once __DIR__ . '/../Views/user/editar.php';
    }

    public function atualizar()
    {
        require_once __DIR__ . '/../Middleware/CsrfMiddleware.php';
        CsrfMiddleware::validate();

        if (!isset($_SESSION['usuario'])) {
            header('Location: ' . App::getBasePath() . '/login');
            exit;
        }

        $id = $_SESSION['usuario']['id'];
        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $telefone = trim($_POST['telefone'] ?? '');
        $dataNascimento = $_POST['data_nascimento'] ?? '';
        $senha = $_POST['senha'] ?? '';

        if (empty($nome) || empty($email)) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Nome e e-mail são obrigatórios.'];
            header('Location: ' . App::getBasePath() . '/user/editar');
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'E-mail inválido.'];
            header('Location: ' . App::getBasePath() . '/user/editar');
            exit;
        }

        if ($this->usuario->emailExists($email, $id)) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Este e-mail já está em uso.'];
            header('Location: ' . App::getBasePath() . '/user/editar');
            exit;
        }

        try {
            $dados = [
                'nome' => $nome,
                'email' => $email,
                'telefone' => $telefone,
                'data_nascimento' => $dataNascimento,
            ];

            if (!empty($senha)) {
            require_once __DIR__ . '/../Helpers/PasswordHelper.php';
            $validacao = PasswordHelper::validate($senha);
            if (!$validacao['valid']) {
                $_SESSION['flash'] = [
                    'tipo' => 'erro', 
                    'mensagem' => 'Senha fraca. Requisitos: ' . implode(', ', $validacao['errors'])
                ];
                header('Location: ' . App::getBasePath() . '/user/editar');
                exit;
            }
            $dados['senha'] = PasswordHelper::hash($senha);
        }

            $this->usuario->update($id, $dados);

            // Atualiza sessão
            $_SESSION['usuario']['nome'] = $nome;
            $_SESSION['usuario']['email'] = $email;

            $_SESSION['flash'] = ['tipo' => 'sucesso', 'mensagem' => 'Dados atualizados com sucesso!'];
            header('Location: ' . App::getBasePath() . '/user');
            exit;

        } catch (Exception $e) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Erro ao atualizar: ' . $e->getMessage()];
            header('Location: ' . App::getBasePath() . '/user/editar');
            exit;
        }
    }
}