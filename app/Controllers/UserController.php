<?php
// app/Controllers/UserController.php
// "Minha Conta": o usuário logado vê e edita os próprios dados.

class UserController extends BaseController
{
    private $usuario;

    public function __construct()
    {
        $this->usuario = new Usuario();
    }

    public function index()
    {
        $usuario = $this->usuario->findById(Auth::id());
        if (!$usuario) {
            $this->redirectWith('/', 'erro', 'Usuário não encontrado.');
        }
        $this->view('user/index', ['usuario' => $usuario]);
    }

    public function editar()
    {
        $usuario = $this->usuario->findById(Auth::id());
        if (!$usuario) {
            $this->redirectWith('/', 'erro', 'Usuário não encontrado.');
        }
        $this->view('user/editar', ['usuario' => $usuario]);
    }

    public function atualizar()
    {
        $id = Auth::id();
        $atual = $this->usuario->find($id);

        $nome = $this->input('nome');
        $email = mb_strtolower($this->input('email'));
        $telefone = $this->input('telefone');
        $dataNascimento = $this->input('data_nascimento');
        $senha = (string) ($_POST['senha'] ?? '');
        $senhaConfirm = (string) ($_POST['senha_confirm'] ?? '');
        $senhaAtual = (string) ($_POST['senha_atual'] ?? '');

        $erro = Usuario::validarDados($nome, $email, $telefone, $dataNascimento);
        if ($erro) {
            $this->redirectWith('/user/editar', 'erro', $erro);
        }
        if ($this->usuario->emailExists($email, $id)) {
            $this->redirectWith('/user/editar', 'erro', 'Este e-mail já está em uso.');
        }

        $dados = [
            'nome' => $nome,
            'email' => $email,
            'telefone' => $telefone,
            'data_nascimento' => $dataNascimento,
        ];

        $trocaEmail = $email !== mb_strtolower($atual['email']);
        $trocaSenha = $senha !== '';

        // Trocar e-mail ou senha exige a senha atual (protege conta deixada aberta)
        if (($trocaEmail || $trocaSenha) && !password_verify($senhaAtual, $atual['senha'])) {
            $this->redirectWith('/user/editar', 'erro', 'Informe sua senha atual corretamente para alterar e-mail ou senha.');
        }

        if ($trocaSenha) {
            if ($senha !== $senhaConfirm) {
                $this->redirectWith('/user/editar', 'erro', 'As senhas não coincidem.');
            }
            $v = PasswordHelper::validate($senha);
            if (!$v['valid']) {
                $this->redirectWith('/user/editar', 'erro', 'Senha fraca: ' . implode(', ', $v['errors']) . '.');
            }
            $dados['senha'] = PasswordHelper::hash($senha);
        }

        $this->usuario->update($id, $dados);
        if ($trocaSenha) {
            session_regenerate_id(true);
        }
        $this->log('atualizar_perfil', $trocaSenha ? 'Dados e senha atualizados' : 'Dados atualizados', 'usuario', $id);

        $this->redirectWith('/user', 'sucesso', 'Dados atualizados com sucesso!');
    }
}
