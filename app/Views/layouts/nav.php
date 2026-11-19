<?php
// app/Views/layouts/nav.php — menu superior, sidebar mobile e mensagens flash.
// Itens do menu: app/Config/menu.php

$usuarioLogado = Auth::user();
$basePath = App::getBasePath();
$appName = App::getName();
$urlLogout = url('/logout?_token=' . urlencode(csrf_token()));
?>

<nav data-no-invert>
    <div class="nav-container">
        <a href="<?= url('/') ?>" class="logo-brand"><?= e(mb_strtoupper($appName)) ?>.</a>

        <ul class="nav-menu">
            <?= MenuHelper::render() ?>
        </ul>

        <div class="nav-actions">
            <?php if ($usuarioLogado): ?>
                <a href="<?= e($urlLogout) ?>" class="btn-logout">Sair</a>
            <?php else: ?>
                <a href="<?= url('/login') ?>" class="btn-login">Entrar</a>
            <?php endif; ?>
        </div>

        <button class="hamburger" id="openBtn" aria-label="Abrir menu" type="button">
            <i class="fas fa-bars" aria-hidden="true"></i>
        </button>
    </div>
</nav>

<!-- SIDEBAR MOBILE -->
<div class="sidebar" id="sidebar" data-no-invert>
    <button class="close-sidebar" id="closeBtn" aria-label="Fechar menu" type="button">
        <i class="fas fa-times" aria-hidden="true"></i>
    </button>

    <div class="sidebar-brand">
        <a href="<?= url('/') ?>" class="logo-brand" style="color: white; font-size: 1.5rem;"><?= e(mb_strtoupper($appName)) ?>.</a>
    </div>

    <div class="sidebar-divider"></div>

    <?= MenuHelper::renderSidebar() ?>

    <div class="sidebar-divider"></div>
    <?php if ($usuarioLogado): ?>
        <a href="<?= e($urlLogout) ?>" style="color: #ef4444;">
            <i class="fas fa-sign-out-alt" aria-hidden="true"></i> Sair
        </a>
    <?php else: ?>
        <a href="<?= url('/login') ?>" class="btn btn-primary" style="text-align: center; color: white !important; justify-content: center;">
            <i class="fas fa-sign-in-alt" aria-hidden="true"></i> Entrar
        </a>
    <?php endif; ?>
</div>

<script src="<?= asset('js/nav.js') ?>"></script>

<?php require __DIR__ . '/flash.php'; ?>
