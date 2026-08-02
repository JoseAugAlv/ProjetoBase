<?php
// app/Controllers/MasterController.php

require_once __DIR__ . '/../Core/App.php';
require_once __DIR__ . '/../Models/Usuario.php';
require_once __DIR__ . '/../Config/database.php';
require_once __DIR__ . '/../Helpers/MenuHelper.php';

class MasterController
{
    public function index()
    {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['role'] != 1) {
            header('Location: ' . App::getBasePath() . '/');
            exit;
        }

        $tituloPagina = 'Área Master - ' . App::getName();
        $cssPagina = 'master.css';
        require_once __DIR__ . '/../Views/master/index.php';
    }

    public function backup()
    {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['role'] != 1) {
            header('Location: ' . App::getBasePath() . '/');
            exit;
        }

        if (!MenuHelper::isModuleEnabled('backup')) {
            http_response_code(404);
            echo "<h1>404 - Módulo não encontrado</h1>";
            exit;
        }

        $tituloPagina = 'Backup - ' . App::getName();
        $cssPagina = 'master.css';
        require_once __DIR__ . '/../Views/master/backup.php';
    }

    public function exportarBackup()
    {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['role'] != 1) {
            header('Location: ' . App::getBasePath() . '/');
            exit;
        }

        if (!MenuHelper::isModuleEnabled('backup')) {
            http_response_code(404);
            exit;
        }

        require_once __DIR__ . '/../Middleware/CsrfMiddleware.php';
        CsrfMiddleware::validate();

        $pdo = Database::getConnection();
        $dbname = App::get('DB_NAME', 'ProjetoBase');

        try {
            $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
            $sql = "-- Backup do banco: {$dbname}\n-- Data: " . date('Y-m-d H:i:s') . "\n\n";

            foreach ($tables as $table) {
                $create = $pdo->query("SHOW CREATE TABLE {$table}")->fetch(PDO::FETCH_ASSOC);
                $sql .= $create['Create Table'] . ";\n\n";

                $rows = $pdo->query("SELECT * FROM {$table}")->fetchAll(PDO::FETCH_ASSOC);
                if ($rows) {
                    foreach ($rows as $row) {
                        $values = array_map(function($v) use ($pdo) {
                            return $v === null ? 'NULL' : $pdo->quote($v);
                        }, $row);
                        $sql .= "INSERT INTO {$table} (" . implode(', ', array_keys($row)) . ") VALUES (" . implode(', ', $values) . ");\n";
                    }
                    $sql .= "\n";
                }
            }

            $pasta = $_SERVER['DOCUMENT_ROOT'] . App::getBasePath() . '/backups/';
            if (!is_dir($pasta)) {
                mkdir($pasta, 0755, true);
            }

            $arquivo = $pasta . 'backup_' . date('Y-m-d_His') . '.sql';
            file_put_contents($arquivo, $sql);

            require_once __DIR__ . '/../Helpers/SecurityHelper.php';
            SecurityHelper::logAuditoria(
                'backup_exportar',
                $_SESSION['usuario']['id'],
                'Backup exportado: ' . basename($arquivo),
                'info'
            );

            $_SESSION['flash'] = [
                'tipo' => 'sucesso',
                'mensagem' => 'Backup exportado com sucesso!'
            ];

        } catch (Exception $e) {
            $_SESSION['flash'] = [
                'tipo' => 'erro',
                'mensagem' => 'Erro ao exportar backup: ' . $e->getMessage()
            ];
        }

        header('Location: ' . App::getBasePath() . '/master/backup');
        exit;
    }

    public function downloadBackup()
    {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['role'] != 1) {
            header('Location: ' . App::getBasePath() . '/');
            exit;
        }

        if (!MenuHelper::isModuleEnabled('backup')) {
            http_response_code(404);
            exit;
        }

        $arquivo = $_GET['arquivo'] ?? '';
        if (empty($arquivo)) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Arquivo não especificado.'];
            header('Location: ' . App::getBasePath() . '/master/backup');
            exit;
        }

        $pasta = $_SERVER['DOCUMENT_ROOT'] . App::getBasePath() . '/backups/';
        $caminho = $pasta . basename($arquivo);

        if (!file_exists($caminho)) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Arquivo não encontrado.'];
            header('Location: ' . App::getBasePath() . '/master/backup');
            exit;
        }

        header('Content-Type: application/sql');
        header('Content-Disposition: attachment; filename="' . basename($caminho) . '"');
        header('Content-Length: ' . filesize($caminho));
        readfile($caminho);
        exit;
    }

    public function excluirBackup()
    {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['role'] != 1) {
            header('Location: ' . App::getBasePath() . '/');
            exit;
        }

        if (!MenuHelper::isModuleEnabled('backup')) {
            http_response_code(404);
            exit;
        }

        $arquivo = $_GET['arquivo'] ?? '';
        if (empty($arquivo)) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Arquivo não especificado.'];
            header('Location: ' . App::getBasePath() . '/master/backup');
            exit;
        }

        $pasta = $_SERVER['DOCUMENT_ROOT'] . App::getBasePath() . '/backups/';
        $caminho = $pasta . basename($arquivo);

        if (file_exists($caminho)) {
            unlink($caminho);
            require_once __DIR__ . '/../Helpers/SecurityHelper.php';
            SecurityHelper::logAuditoria(
                'backup_excluir',
                $_SESSION['usuario']['id'],
                'Backup excluído: ' . basename($arquivo),
                'warning'
            );
            $_SESSION['flash'] = ['tipo' => 'sucesso', 'mensagem' => 'Backup excluído com sucesso!'];
        } else {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Arquivo não encontrado.'];
        }

        header('Location: ' . App::getBasePath() . '/master/backup');
        exit;
    }

    public function configuracoes()
    {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['role'] != 1) {
            header('Location: ' . App::getBasePath() . '/');
            exit;
        }

        $usuarioModel = new Usuario();
        $totalUsuarios = $usuarioModel->getTotal();

        $tituloPagina = 'Configurações - ' . App::getName();
        $cssPagina = 'master.css';
        require_once __DIR__ . '/../Views/master/configuracoes.php';
    }

    public function usuarios()
    {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['role'] != 1) {
            header('Location: ' . App::getBasePath() . '/');
            exit;
        }

        $usuarioModel = new Usuario();
        $usuarios = $usuarioModel->getAll();

        $tituloPagina = 'Master Usuários - ' . App::getName();
        $cssPagina = 'master.css';
        require_once __DIR__ . '/../Views/master/usuarios.php';
    }

    public function atribuirPerfil()
    {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['role'] != 1) {
            header('Location: ' . App::getBasePath() . '/');
            exit;
        }

        require_once __DIR__ . '/../Middleware/CsrfMiddleware.php';
        CsrfMiddleware::validate();

        $idUsuario = (int) ($_POST['id_usuario'] ?? 0);
        $idPerfil = (int) ($_POST['id_perfil'] ?? 0);

        if (!$idUsuario || !$idPerfil) {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Dados inválidos.'];
            header('Location: ' . App::getBasePath() . '/master/usuarios');
            exit;
        }

        $usuarioModel = new Usuario();
        
        if ($usuarioModel->atualizarPerfil($idUsuario, $idPerfil)) {
            require_once __DIR__ . '/../Helpers/SecurityHelper.php';
            SecurityHelper::logAuditoria(
                'atribuir_perfil_master',
                $_SESSION['usuario']['id'],
                "Perfil atribuído: Usuário ID {$idUsuario} -> Perfil ID {$idPerfil}",
                'info'
            );

            $_SESSION['flash'] = ['tipo' => 'sucesso', 'mensagem' => 'Perfil atribuído com sucesso!'];
        } else {
            $_SESSION['flash'] = ['tipo' => 'erro', 'mensagem' => 'Erro ao atribuir perfil.'];
        }

        header('Location: ' . App::getBasePath() . '/master/usuarios');
        exit;
    }
}