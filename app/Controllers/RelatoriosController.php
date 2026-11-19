<?php
// app/Controllers/RelatoriosController.php — relatórios e exportação (módulo 'export')

class RelatoriosController extends BaseController
{
    private $usuario;

    public function __construct()
    {
        $this->usuario = new Usuario();
    }

    public function usuarios()
    {
        $this->view('relatorios/usuarios', ['usuarios' => $this->usuario->listar()]);
    }

    public function exportar()
    {
        $this->exigirModuloExport();
        $this->log('exportar_excel', 'Relatório de usuários');

        $dados = array_map(function ($u) {
            return [
                'ID' => $u['id_usuario'],
                'Nome' => $u['nome'],
                'E-mail' => $u['email'],
                'Telefone' => $u['telefone'],
                'Perfil' => $u['nome_perfil'],
                'Ativo' => $u['ativo'] ? 'Sim' : 'Não',
                'Criado em' => $u['data_criacao'],
            ];
        }, $this->usuario->listar());

        ExcelHelper::gerar($dados, 'usuarios_' . date('Y-m-d') . '.xls', 'Relatório de Usuários');
    }

    public function pdf()
    {
        $this->exigirModuloExport();
        $this->log('exportar_pdf', 'Relatório de usuários');

        $html = '<h1>Relatório de Usuários</h1><p>Gerado em: ' . date('d/m/Y H:i') . '</p>'
            . '<table border="1" cellpadding="5"><tr><th>ID</th><th>Nome</th><th>E-mail</th><th>Perfil</th><th>Status</th></tr>';

        foreach ($this->usuario->listar() as $u) {
            $html .= '<tr><td>' . (int) $u['id_usuario'] . '</td><td>' . e($u['nome']) . '</td><td>' . e($u['email'])
                . '</td><td>' . e($u['nome_perfil'] ?? '') . '</td><td>' . ($u['ativo'] ? 'Ativo' : 'Inativo') . '</td></tr>';
        }

        PdfHelper::gerar($html . '</table>', 'relatorio_usuarios_' . date('Y-m-d') . '.pdf');
    }

    private function exigirModuloExport(): void
    {
        if (!MenuHelper::isModuleEnabled('export')) {
            $this->abort(404);
        }
    }
}
