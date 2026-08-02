<?php
// app/Views/master/configuracoes.php

$tituloPagina = 'Configurações - ' . App::getName();
$cssPagina = 'master.css';
$basePath = App::getBasePath();
$appName = App::getName();

require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/nav.php';

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['role'] != 1) {
    header('Location: ' . $basePath . '/');
    exit;
}
?>

<section class="master-section animate-in">
    <div class="container">
        <div class="master-content">

            <!-- Hero -->
            <div class="master-hero">
                <div>
                    <h1><i class="fas fa-cog" style="color: #0284c7;"></i> Configurações do Sistema</h1>
                    <p class="master-subtitle">
                        <i class="fas fa-sliders-h"></i> Gerencie as configurações e informações do sistema
                    </p>
                </div>
                <span class="badge-count">
                    <i class="fas fa-version"></i> v1.0
                </span>
            </div>

            <!-- Informações do Sistema -->
            <div class="master-box box-info">
                <h2><i class="fas fa-info-circle"></i> Informações do Sistema</h2>
                <div class="info-item">
                    <strong><i class="fas fa-tag"></i> Nome:</strong>
                    <span><?= $appName ?></span>
                </div>
                <div class="info-item">
                    <strong><i class="fab fa-php"></i> PHP:</strong>
                    <span><?= phpversion() ?></span>
                </div>
                <div class="info-item">
                    <strong><i class="fas fa-database"></i> Banco de Dados:</strong>
                    <span>MySQL</span>
                </div>
                <div class="info-item">
                    <strong><i class="fas fa-server"></i> Servidor:</strong>
                    <span><?= $_SERVER['SERVER_SOFTWARE'] ?? 'N/A' ?></span>
                </div>
                <div class="info-item">
                    <strong><i class="fas fa-calendar-alt"></i> Data/Hora:</strong>
                    <span><?= date('d/m/Y H:i:s') ?></span>
                </div>
                <?php if (isset($totalUsuarios)): ?>
                <div class="info-item">
                    <strong><i class="fas fa-users"></i> Total Usuários:</strong>
                    <span><?= $totalUsuarios ?></span>
                </div>
                <?php endif; ?>
            </div>

            <!-- Ações do Sistema -->
            <div class="master-box">
                <h2><i class="fas fa-tools"></i> Ações do Sistema</h2>
                <div class="acoes-grid">
                    <a href="<?= $basePath ?>/master/backup" class="btn-action btn-warning">
                        <i class="fas fa-database"></i> Fazer Backup
                    </a>
                    <a href="<?= $basePath ?>/logs" class="btn-action btn-secondary">
                        <i class="fas fa-history"></i> Logs do Sistema
                    </a>
                    <a href="<?= $basePath ?>/usuarios" class="btn-action btn-primary">
                        <i class="fas fa-users"></i> Gerenciar Usuários
                    </a>
                </div>
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