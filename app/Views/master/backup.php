<?php
// app/Views/master/backup.php

$tituloPagina = 'Backup - ' . App::getName();
$cssPagina = 'master.css';
$basePath = App::getBasePath();
$appName = App::getName();

require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/nav.php';

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['role'] != 1) {
    header('Location: ' . $basePath . '/');
    exit;
}

if (isset($_SESSION['flash'])) {
    $flash = $_SESSION['flash'];
    echo '<div class="flash-' . $flash['tipo'] . '">' . htmlspecialchars($flash['mensagem']) . '</div>';
    unset($_SESSION['flash']);
}

$pasta = $_SERVER['DOCUMENT_ROOT'] . $basePath . '/backups/';
if (!file_exists($pasta)) {
    mkdir($pasta, 0777, true);
}
$backups = glob($pasta . '*.sql');
rsort($backups);
?>

<section class="master-section animate-in">
    <div class="container">
        <div class="master-content">

            <!-- Hero -->
            <div class="master-hero">
                <div>
                    <h1><i class="fas fa-database" style="color: #d97706;"></i> Backup do Sistema</h1>
                    <p class="master-subtitle">
                        <i class="fas fa-shield-alt"></i> Gerencie os backups do banco de dados
                    </p>
                </div>
                <span class="badge-count">
                    <i class="fas fa-file-archive"></i> <?= count($backups) ?> backup(s)
                </span>
            </div>

            <!-- Exportar Backup -->
            <div class="master-box box-warning">
                <h2><i class="fas fa-download"></i> Exportar Banco de Dados</h2>
                <p class="box-description">Clique no botão abaixo para exportar o banco de dados completo.</p>
                <form action="<?= $basePath ?>/master/backup/exportar" method="POST">
                    <?= ViewHelper::csrfField() ?>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-file-export"></i> Exportar Backup
                    </button>
                </form>
            </div>

            <!-- Backups Disponíveis -->
            <div class="master-box">
                <h2><i class="fas fa-list"></i> Backups Disponíveis</h2>
                
                <?php if (empty($backups)): ?>
                    <div class="empty-state small">
                        <i class="fas fa-inbox"></i>
                        <p>Nenhum backup disponível.</p>
                    </div>
                <?php else: ?>
                    <div class="master-table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Arquivo</th>
                                    <th>Tamanho</th>
                                    <th>Data</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($backups as $backup): 
                                    $tamanho = filesize($backup);
                                    $tamanhoFormatado = $tamanho > 1048576 
                                        ? number_format($tamanho / 1048576, 2) . ' MB' 
                                        : number_format($tamanho / 1024, 2) . ' KB';
                                ?>
                                    <tr>
                                        <td><strong><?= basename($backup) ?></strong></td>
                                        <td><?= $tamanhoFormatado ?></td>
                                        <td><?= date('d/m/Y H:i', filemtime($backup)) ?></td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="<?= $basePath ?>/master/backup/download?arquivo=<?= urlencode(basename($backup)) ?>" class="btn btn-sm btn-download">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                                <a href="<?= $basePath ?>/master/backup/excluir?arquivo=<?= urlencode(basename($backup)) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este backup?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="backup-info">
                        <i class="fas fa-info-circle"></i> 
                        <?= count($backups) ?> backup(s) disponível(is).
                        <?php 
                        $totalTamanho = array_sum(array_map('filesize', $backups));
                        $totalFormatado = $totalTamanho > 1048576 
                            ? number_format($totalTamanho / 1048576, 2) . ' MB' 
                            : number_format($totalTamanho / 1024, 2) . ' KB';
                        ?>
                        Tamanho total: <strong><?= $totalFormatado ?></strong>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Voltar -->
            <div class="master-voltar">
                <a href="<?= $basePath ?>/master" class="btn">
                    <i class="fas fa-arrow-left"></i> Voltar para Área Master
                </a>
            </div>

        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>