<?php
// app/Controllers/MasterController.php
// Área do Master: painel, configurações, usuários e backup do banco.

class MasterController extends BaseController
{
    public function index()
    {
        $this->view('master/index');
    }

    public function configuracoes()
    {
        $this->view('master/configuracoes', ['totalUsuarios' => (new Usuario())->getTotal()]);
    }

    public function usuarios()
    {
        $usuario = new Usuario();
        $this->view('master/usuarios', [
            'usuarios' => $usuario->listar(),
            'perfis' => $usuario->getPerfis(),
        ]);
    }

    // ------------------------------------------------------------
    // BACKUP (módulo 'backup' em app/Config/modules.php)
    // Arquivos ficam em /backups, fora de public/ e bloqueados por .htaccess.
    // ------------------------------------------------------------

    public function backup()
    {
        $arquivos = glob($this->pastaBackup() . '/*.sql') ?: [];
        rsort($arquivos);
        $this->view('master/backup', ['backups' => $arquivos]);
    }

    public function exportarBackup()
    {
        @set_time_limit(300);
        $pdo = Database::getConnection();

        $sql = "-- Backup do banco: " . App::get('DB_NAME') . "\n-- Data: " . date('Y-m-d H:i:s') . "\n\n"
            . "SET NAMES utf8mb4;\nSET FOREIGN_KEY_CHECKS = 0;\n\n";

        foreach ($pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN) as $tabela) {
            $t = '`' . str_replace('`', '``', $tabela) . '`';
            $create = $pdo->query("SHOW CREATE TABLE {$t}")->fetch(PDO::FETCH_NUM);
            $sql .= "DROP TABLE IF EXISTS {$t};\n" . $create[1] . ";\n\n";

            $stmt = $pdo->query("SELECT * FROM {$t}");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $colunas = implode(', ', array_map(function ($c) {
                    return '`' . str_replace('`', '``', $c) . '`';
                }, array_keys($row)));
                $valores = implode(', ', array_map(function ($v) use ($pdo) {
                    return $v === null ? 'NULL' : $pdo->quote((string) $v);
                }, $row));
                $sql .= "INSERT INTO {$t} ({$colunas}) VALUES ({$valores});\n";
            }
            $sql .= "\n";
        }
        $sql .= "SET FOREIGN_KEY_CHECKS = 1;\n";

        $nome = 'backup_' . date('Y-m-d_His') . '.sql';
        if (file_put_contents($this->pastaBackup() . '/' . $nome, $sql) === false) {
            $this->redirectWith('/master/backup', 'erro', 'Não foi possível gravar o arquivo de backup.');
        }

        $this->log('backup_exportar', 'Backup gerado: ' . $nome);
        $this->redirectWith('/master/backup', 'sucesso', 'Backup gerado com sucesso!');
    }

    public function downloadBackup()
    {
        $caminho = $this->arquivoBackup((string) ($_GET['arquivo'] ?? ''));
        if (!$caminho) {
            $this->redirectWith('/master/backup', 'erro', 'Arquivo não encontrado.');
        }

        $this->log('backup_download', 'Download: ' . basename($caminho));
        while (ob_get_level() > 0) {
            ob_end_clean();
        }
        header('Content-Type: application/sql');
        header('Content-Disposition: attachment; filename="' . basename($caminho) . '"');
        header('Content-Length: ' . filesize($caminho));
        readfile($caminho);
        exit;
    }

    /** POST */
    public function excluirBackup()
    {
        $caminho = $this->arquivoBackup((string) ($_POST['arquivo'] ?? ''));
        if (!$caminho) {
            $this->redirectWith('/master/backup', 'erro', 'Arquivo não encontrado.');
        }

        unlink($caminho);
        $this->log('backup_excluir', 'Backup excluído: ' . basename($caminho), null, null, 'warning');
        $this->redirectWith('/master/backup', 'sucesso', 'Backup excluído com sucesso!');
    }

    private function pastaBackup(): string
    {
        $pasta = ROOT_PATH . '/backups';
        if (!is_dir($pasta)) {
            mkdir($pasta, 0750, true);
        }
        return $pasta;
    }

    /** Só aceita nomes no formato gerado pelo sistema (bloqueia path traversal). */
    private function arquivoBackup(string $nome): ?string
    {
        if (!preg_match('/^backup_\d{4}-\d{2}-\d{2}_\d{6}\.sql$/', $nome)) {
            return null;
        }
        return SecurityHelper::sanitizarCaminhoArquivo($nome, $this->pastaBackup(), ['sql']);
    }
}
