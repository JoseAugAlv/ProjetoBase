<?php
// app/Views/notificacoes/index.php

$tituloPagina = 'Minhas Notificações - ' . App::getName();
$cssPagina = 'notificacoes.css';
$basePath = App::getBasePath();
$appName = App::getName();

require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/nav.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: ' . $basePath . '/login');
    exit;
}

if (isset($_SESSION['flash'])) {
    $flash = $_SESSION['flash'];
    echo '<div class="flash-' . $flash['tipo'] . '">' . htmlspecialchars($flash['mensagem']) . '</div>';
    unset($_SESSION['flash']);
}

$naoLidas = 0;
$notificacoesNovas = [];
$notificacoesAntigas = [];

if (!empty($notificacoes)) {
    foreach ($notificacoes as $n) {
        if (!$n['lida']) {
            $naoLidas++;
            $notificacoesNovas[] = $n;
        } else {
            $notificacoesAntigas[] = $n;
        }
    }
}

$mostrarTodas = isset($_GET['todas']) && $_GET['todas'] == '1';
$notificacoesExibir = $mostrarTodas ? $notificacoes : $notificacoesNovas;
?>

<section class="notificacoes-section animate-in">
    <div class="container">
        <div class="notificacoes-content">

            <!-- Hero -->
            <div class="notificacoes-hero">
                <div>
                    <h1><i class="fas fa-bell" style="color: var(--color-impact-green);"></i> Minhas Notificações</h1>
                    <p class="notificacoes-subtitle">
                        <i class="fas fa-inbox"></i> Fique por dentro de tudo que acontece
                    </p>
                </div>
                <span class="badge-count">
                    <i class="fas fa-bell"></i> 
                    <?php if ($mostrarTodas): ?>
                        <?= count($notificacoes ?? []) ?> notificação(ões)
                    <?php else: ?>
                        <?= count($notificacoesNovas) ?> nova(s)
                    <?php endif; ?>
                    <?php if ($naoLidas > 0 && !$mostrarTodas): ?>
                        <span class="badge-nao-lidas"><?= $naoLidas ?> não lidas</span>
                    <?php endif; ?>
                </span>
            </div>

            <!-- Filtros e Botões -->
            <?php if (!empty($notificacoes)): ?>
                <div class="notificacoes-filtros">
                    <div class="filtros-group">
                        <a href="<?= $basePath ?>/notificacoes" class="btn-filtro <?= !$mostrarTodas ? 'active' : '' ?>">
                            <i class="fas fa-circle"></i> Novas
                            <?php if ($naoLidas > 0): ?>
                                <span class="badge-filtro"><?= $naoLidas ?></span>
                            <?php endif; ?>
                        </a>
                        <a href="<?= $basePath ?>/notificacoes?todas=1" class="btn-filtro <?= $mostrarTodas ? 'active' : '' ?>">
                            <i class="fas fa-check-circle"></i> Todas
                            <span class="badge-filtro"><?= count($notificacoes ?? []) ?></span>
                        </a>
                    </div>
                    
                    <?php if ($naoLidas > 0): ?>
                        <form action="<?= $basePath ?>/notificacoes/marcar-todas-lidas" method="POST">
                            <?= ViewHelper::csrfField() ?>
                            <button type="submit" class="btn-marcar-todas">
                                <i class="fas fa-check-double"></i> Marcar todas como lidas
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Lista de Notificações -->
            <?php if (empty($notificacoesExibir)): ?>
                <div class="empty-state">
                    <?php if ($mostrarTodas): ?>
                        <i class="fas fa-bell-slash"></i>
                        <h3>Nenhuma notificação</h3>
                        <p>Você não tem notificações no momento.</p>
                        <a href="<?= $basePath ?>/" class="btn btn-sm">
                            <i class="fas fa-home"></i> Início
                        </a>
                    <?php else: ?>
                        <i class="fas fa-check-circle" style="color: var(--color-impact-green);"></i>
                        <h3>Nenhuma notificação nova!</h3>
                        <p>Você leu todas as notificações.</p>
                        <div class="empty-actions">
                            <a href="<?= $basePath ?>/notificacoes?todas=1" class="btn btn-sm">
                                <i class="fas fa-history"></i> Ver histórico
                            </a>
                            <a href="<?= $basePath ?>/" class="btn btn-sm">
                                <i class="fas fa-home"></i> Início
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="lista-notificacoes">
                    <?php foreach ($notificacoesExibir as $notificacao): ?>
                        <div class="notificacao-item <?= $notificacao['lida'] ? 'lida' : 'nao-lida' ?>">
                            <div class="notificacao-conteudo">
                                <div class="notificacao-titulo">
                                    <?= htmlspecialchars($notificacao['titulo']) ?>
                                    <?php if (!$notificacao['lida']): ?>
                                        <span class="badge-nao-lida">
                                            <i class="fas fa-circle"></i> Nova
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <p class="notificacao-mensagem"><?= htmlspecialchars($notificacao['mensagem']) ?></p>
                                <small class="notificacao-data">
                                    <i class="far fa-clock"></i> <?= date('d/m/Y H:i', strtotime($notificacao['data_criacao'])) ?>
                                </small>
                            </div>
                            <?php if (!$notificacao['lida']): ?>
                                <form action="<?= $basePath ?>/notificacoes/marcar-lida" method="POST">
                                    <?= ViewHelper::csrfField() ?>
                                    <input type="hidden" name="id_notificacao" value="<?= $notificacao['id_notificacao'] ?>">
                                    <button type="submit" class="btn-marcar-lida">
                                        <i class="fas fa-check"></i> Marcar como lida
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <?php if ($mostrarTodas && count($notificacoesAntigas) > 0): ?>
                    <div class="info-historico">
                        <i class="fas fa-info-circle"></i> 
                        Mostrando todas as notificações. 
                        <a href="<?= $basePath ?>/notificacoes">Ver apenas as novas</a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <!-- Voltar -->
            <div class="notificacoes-voltar">
                <a href="<?= $basePath ?>/" class="btn btn-sm">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>

        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>