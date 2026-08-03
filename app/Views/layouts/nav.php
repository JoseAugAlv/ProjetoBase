<?php
// app/Views/layouts/nav.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../Helpers/NavHelper.php';
require_once __DIR__ . '/../../Helpers/MenuHelper.php';

$usuario = $_SESSION['usuario'] ?? null;
$appName = App::getName();
$basePath = App::getBasePath();

if ($usuario) {
    $perfil = $usuario['role'] ?? 4;
    $_SESSION['usuario']['role'] = $perfil;
    $totalNotificacoes = NavHelper::getContadorNotificacoes($usuario['id']);
} else {
    $perfil = null;
    $totalNotificacoes = 0;
}
?>

<nav>
    <div class="nav-container">
        <a href="<?= $basePath ?>/" class="logo-brand"><?= strtoupper($appName) ?>.</a>

        <ul class="nav-menu">
            <?= MenuHelper::render() ?>
        </ul>

        <div class="nav-actions">
            <?php if ($usuario): ?>
                <a href="<?= $basePath ?>/logout" class="btn-logout">Sair</a>
            <?php else: ?>
                <a href="<?= $basePath ?>/login" class="btn-login">Entrar</a>
            <?php endif; ?>
        </div>

        <button class="hamburger" id="openBtn" aria-label="Abrir menu" type="button">
            <i class="fas fa-bars" aria-hidden="true"></i>
        </button>
    </div>
</nav>

<!-- SIDEBAR MOBILE -->
<div class="sidebar" id="sidebar">
    <button class="close-sidebar" id="closeBtn" aria-label="Fechar menu" type="button">
        <i class="fas fa-times" aria-hidden="true"></i>
    </button>

    <div class="sidebar-brand">
        <a href="<?= $basePath ?>/" class="logo-brand" style="color: white; font-size: 1.5rem;"><?= strtoupper($appName) ?>.</a>
    </div>

    <div class="sidebar-divider"></div>

    <?= MenuHelper::renderSidebar() ?>

    <?php if ($usuario): ?>
        <div class="sidebar-divider"></div>
        <a href="<?= $basePath ?>/logout" style="color: #ef4444;">
            <i class="fas fa-sign-out-alt" aria-hidden="true"></i> Sair
        </a>
    <?php else: ?>
        <div class="sidebar-divider"></div>
        <a href="<?= $basePath ?>/login" class="btn btn-primary" style="text-align: center; color: white !important; justify-content: center;">
            <i class="fas fa-sign-in-alt" aria-hidden="true"></i> Entrar
        </a>
    <?php endif; ?>
</div>

<!-- Carrega apenas o arquivo nav.js -->
<script src="<?= $basePath ?>/public/js/nav.js"></script>