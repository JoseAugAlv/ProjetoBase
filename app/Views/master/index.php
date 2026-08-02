<?php
// app/Views/master/index.php

$tituloPagina = 'Área Master - ' . App::getName();
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
?>

<section class="master-section animate-in">
    <div class="container">
        <div class="master-content">

            <!-- Hero -->
            <div class="master-hero">
                <div>
                    <h1><i class="fas fa-crown" style="color: #f59e0b;"></i> Área Master</h1>
                    <p class="master-subtitle">
                        <i class="fas fa-shield-alt"></i> Controle total do sistema
                    </p>
                </div>
                <span class="badge-count">
                    <i class="fas fa-user-shield"></i> Master
                </span>
            </div>

            <!-- Cards Master -->
            <div class="master-cards">
                <div class="master-card">
                    <div class="master-card-icon"><i class="fas fa-users"></i></div>
                    <h3>Usuários</h3>
                    <p>Gerenciar todos os usuários do sistema</p>
                    <a href="<?= $basePath ?>/usuarios" class="btn-master btn-primary">
                        <i class="fas fa-arrow-right"></i> Acessar
                    </a>
                </div>

                <div class="master-card">
                    <div class="master-card-icon"><i class="fas fa-history"></i></div>
                    <h3>Logs</h3>
                    <p>Visualizar logs do sistema</p>
                    <a href="<?= $basePath ?>/logs" class="btn-master btn-secondary">
                        <i class="fas fa-arrow-right"></i> Acessar
                    </a>
                </div>

                <div class="master-card">
                    <div class="master-card-icon"><i class="fas fa-cog"></i></div>
                    <h3>Configurações</h3>
                    <p>Configurações do sistema</p>
                    <a href="<?= $basePath ?>/master/configuracoes" class="btn-master btn-info">
                        <i class="fas fa-arrow-right"></i> Acessar
                    </a>
                </div>

                <div class="master-card">
                    <div class="master-card-icon"><i class="fas fa-database"></i></div>
                    <h3>Backup</h3>
                    <p>Gerenciar backups do sistema</p>
                    <a href="<?= $basePath ?>/master/backup" class="btn-master btn-warning">
                        <i class="fas fa-arrow-right"></i> Acessar
                    </a>
                </div>
            </div>

            <!-- Voltar -->
            <div class="master-voltar">
                <a href="<?= $basePath ?>/" class="btn">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>

        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>