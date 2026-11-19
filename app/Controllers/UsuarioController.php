<?php
// app/Controllers/UsuarioController.php
// Gestão de usuários (Master e Admin).
// Regra de hierarquia em Perfil::podeGerenciar(): Master gerencia todos;
// Admin só gerencia/atribui Operador e Usuario.

class UsuarioController extends BaseController
{
    private $usuario;

    public function __construct()
    {
        $this->usuario = new Usuario();
    }

    public function index()
    {
        $pagina = max(1, $this->inputInt('pagina', 1));
        $limite = 20;

        $total = $this->usuario->getTotal();
        $paginacao = PaginationHelper::paginate($total, $pagina, $limite);

        $this->view('usuarios/index', [
            'usuarios' => $this->usuario->getWithPagination($limite, $paginacao['offset']),
            'total' => $total,
            'perfis' => $this->usuario->getPerfis(),
            'role' => Auth::role(),
            'paginationHtml' => PaginationHelper::render(url('/usuarios'), $paginacao['paginaAtual'], $paginacao['totalPaginas']),
        ]);
    }

    public function criar()
    {
        $this->view('usuarios/criar', ['perfis' => $this->perfisPermitidos()]);
    }

    public function salvar()
    {
        $nome = $this->input('nome');
        $email = mb_strtolower($this->input('email'));
        $telefone = $this->input('telefone');
        $dataNascimento = $this->input('data_nascimento');
        $idPerfil = $this->inputInt('id_perfil', Perfil::USUARIO);
        $senha = (string) ($_POST['senha'] ?? '');

        $erro = Usuario::validarDados($nome, $email, $telefone, $dataNascimento);
        if (!$erro && !in_array($idPerfil, Perfil::atribuiveis(Auth::role()), true)) {
            $erro = 'Você não pode criar usuários com esse perfil.';
        }
        if (!$erro && $this->usuario->emailExists($email)) {
            $erro = 'Este e-mail já está cadastrado.';
        }
        if (!$erro && $senha !== '') {
            $v = PasswordHelper::validate($senha);
            $erro = $v['valid'] ? null : 'Senha fraca: ' . implode(', ', $v['errors']) . '.';
        }
        if ($erro) {
            $this->redirectWith('/usuarios/criar', 'erro', $erro);
        }

        $id = $this->usuario->create([
            'nome' => $nome,
            'email' => $email,
            // Sem senha informada: senha aleatória; o usuário define a dele pelo link do e-mail
            'senha' => PasswordHelper::hash($senha !== '' ? $senha : PasswordHelper::generateTemp(24)),
            'telefone' => $telefone,
            'data_nascimento' => $dataNascimento,
            'id_perfil' => $idPerfil,
            'email_verificado' => 1,
        ]);

        // Nunca manda senha por e-mail: manda link para definir a senha (vale 48h)
        $token = (new ResetSenha())->criar($id, 60 * 48);
        $enviado = (new Mail())->sendBoasVindas($email, $nome, $token);

        $this->log('criar_usuario', "Usuário criado: {$email} (perfil " . Perfil::getNome($idPerfil) . ')', 'usuario', $id);

        $this->redirectWith('/usuarios', $enviado ? 'sucesso' : 'aviso', $enviado
            ? 'Usuário criado! Enviamos um e-mail para ele definir a senha.'
            : 'Usuário criado, mas o e-mail não pôde ser enviado. Peça para ele usar "Esqueci minha senha".');
    }

    public function editar()
    {
        $alvo = $this->carregarAlvoGerenciavel($this->inputInt('id'));
        $this->view('usuarios/editar', [
            'usuario' => $alvo,
            'perfis' => $this->perfisPermitidos(),
            'editandoASiMesmo' => (int) $alvo['id_usuario'] === Auth::id(),
        ]);
    }

    public function atualizar()
    {
        $id = $this->inputInt('id_usuario');
        $alvo = $this->carregarAlvoGerenciavel($id);
        $voltar = '/usuarios/editar?id=' . $id;

        $nome = $this->input('nome');
        $email = mb_strtolower($this->input('email'));
        $telefone = $this->input('telefone');
        $dataNascimento = $this->input('data_nascimento');
        $idPerfil = $this->inputInt('id_perfil', (int) $alvo['id_perfil']);
        $ativo = isset($_POST['ativo']) ? 1 : 0;
        $senha = (string) ($_POST['senha'] ?? '');

        // Ninguém muda o próprio perfil nem se desativa por aqui
        if ($id === Auth::id()) {
            $idPerfil = (int) $alvo['id_perfil'];
            $ativo = 1;
        }

        $erro = Usuario::validarDados($nome, $email, $telefone, $dataNascimento);
        if (!$erro && $idPerfil !== (int) $alvo['id_perfil'] && !in_array($idPerfil, Perfil::atribuiveis(Auth::role()), true)) {
            $erro = 'Você não pode atribuir esse perfil.';
        }
        if (!$erro && $this->usuario->emailExists($email, $id)) {
            $erro = 'Este e-mail já está em uso.';
        }

        $dados = [
            'nome' => $nome,
            'email' => $email,
            'telefone' => $telefone,
            'data_nascimento' => $dataNascimento,
            'id_perfil' => $idPerfil,
            'ativo' => $ativo,
        ];

        if (!$erro && $senha !== '') {
            $v = PasswordHelper::validate($senha);
            $erro = $v['valid'] ? null : 'Senha fraca: ' . implode(', ', $v['errors']) . '.';
            $dados['senha'] = PasswordHelper::hash($senha);
        }
        if ($erro) {
            $this->redirectWith($voltar, 'erro', $erro);
        }

        $this->usuario->update($id, $dados);
        $this->log('atualizar_usuario', "Usuário atualizado: {$email}", 'usuario', $id);

        $this->redirectWith('/usuarios', 'sucesso', 'Usuário atualizado com sucesso!');
    }

    /** POST — desativa (soft delete). */
    public function excluir()
    {
        $id = $this->inputInt('id');
        if ($id === Auth::id()) {
            $this->redirectWith('/usuarios', 'erro', 'Você não pode desativar sua própria conta.');
        }
        $alvo = $this->carregarAlvoGerenciavel($id);

        $this->usuario->update($id, ['ativo' => 0]);
        $this->log('desativar_usuario', 'Usuário desativado: ' . $alvo['email'], 'usuario', $id, 'warning');

        $this->redirectWith('/usuarios', 'sucesso', 'Usuário desativado com sucesso!');
    }

    /** POST — troca só o perfil (usado pelo modal da área Master). */
    public function atribuirPerfil()
    {
        $id = $this->inputInt('id_usuario');
        $idPerfil = $this->inputInt('id_perfil');

        if ($id === Auth::id()) {
            $this->flash('erro', 'Você não pode alterar o próprio perfil.');
            $this->back('/usuarios');
        }
        $this->carregarAlvoGerenciavel($id);

        if (!in_array($idPerfil, Perfil::atribuiveis(Auth::role()), true)) {
            $this->flash('erro', 'Você não pode atribuir esse perfil.');
            $this->back('/usuarios');
        }

        $this->usuario->atualizarPerfil($id, $idPerfil);
        $this->log('atribuir_perfil', "Usuário {$id} -> " . Perfil::getNome($idPerfil), 'usuario', $id);

        $this->flash('sucesso', 'Perfil atribuído com sucesso!');
        $this->back('/usuarios');
    }

    // ------------------------------------------------------------

    /** Carrega o usuário alvo e garante que o logado tem hierarquia para mexer nele. */
    private function carregarAlvoGerenciavel(int $id): array
    {
        $alvo = $id ? $this->usuario->findById($id) : null;
        if (!$alvo) {
            $this->redirectWith('/usuarios', 'erro', 'Usuário não encontrado.');
        }
        if ((int) $alvo['id_usuario'] !== Auth::id() && !Perfil::podeGerenciar(Auth::role(), (int) $alvo['id_perfil'])) {
            $this->redirectWith('/usuarios', 'erro', 'Você não tem permissão para gerenciar este usuário.');
        }
        return $alvo;
    }

    private function perfisPermitidos(): array
    {
        $permitidos = Perfil::atribuiveis(Auth::role());
        return array_values(array_filter($this->usuario->getPerfis(), function ($p) use ($permitidos) {
            return in_array((int) $p['id_perfil'], $permitidos, true);
        }));
    }
}
