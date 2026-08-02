<?php
// app/Views/home/index.php

$tituloPagina = $tituloPagina ?? 'Início - ' . App::getName();
$cssPagina = 'home.css'; 
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/nav.php';

$usuario = $_SESSION['usuario'] ?? null;
$role = $usuario['role'] ?? null;
$nome = $usuario['nome'] ?? 'Visitante';
$appName = App::getName();
$basePath = App::getBasePath();
?>

<!-- HERO SECTION -->
<section class="hero-section animate-in">
    <div class="hero-overlay"></div>
    <div class="hero-container">
        <h1><?= $usuario ? 'Bem-vindo, ' . htmlspecialchars($nome) . '!' : 'Bem-vindo ao ' . $appName . '!' ?></h1>
        <p>Sistema de gestão de usuários e permissões. Gerencie seu acesso de forma simples e profissional.</p>
        <div class="hero-buttons">
            <?php if ($usuario): ?>
                <a href="<?= $basePath ?>/user" class="btn btn-primary">Minha Conta</a>
                <?php if ($role == 1 || $role == 2): ?>
                    <a href="<?= $basePath ?>/usuarios" class="btn btn-outline">Gerenciar Usuários</a>
                <?php endif; ?>
            <?php else: ?>
                <a href="<?= $basePath ?>/login" class="btn btn-primary">Entrar</a>
                <a href="<?= $basePath ?>/login/cadastrar" class="btn btn-outline">Criar Conta</a>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- STATS / MÉTRICAS -->
<section class="section-block animate-in delay-1">
    <div class="stats-grid">
        <div class="stat-box">
            <strong><?= $totalUsuarios ?? 0 ?></strong>
            <p>Usuários Cadastrados</p>
        </div>
        <div class="stat-box">
            <strong><?= $totalAtivos ?? 0 ?></strong>
            <p>Usuários Ativos</p>
        </div>
        <?php if ($usuario && $role == 1): ?>
        <div class="stat-box">
            <strong><?= $primeiroAcessoPendentes ?? 0 ?></strong>
            <p>Primeiro Acesso Pendente</p>
        </div>
        <?php endif; ?>
        <div class="stat-box">
            <strong><?= count($perfis ?? []) ?></strong>
            <p>Perfis Disponíveis</p>
        </div>
    </div>
</section>

<!-- LINKS RÁPIDOS -->
<section class="section-block animate-in delay-2">
    <h2>Links Rápidos</h2>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem;">
        <?php if ($usuario): ?>
            <a href="<?= $basePath ?>/user" class="btn btn-primary" style="justify-content: center;">
                <i class="fas fa-user"></i> Minha Conta
            </a>
            <a href="<?= $basePath ?>/notificacoes" class="btn" style="justify-content: center;">
                <i class="fas fa-bell"></i> Notificações
                <?php if ($totalNotificacoes > 0): ?>
                    <span style="background: #dc2626; color: white; border-radius: 50%; padding: 0.1rem 0.6rem; font-size: 0.7rem; margin-left: 0.3rem;">
                        <?= $totalNotificacoes ?>
                    </span>
                <?php endif; ?>
            </a>
            
            <?php if ($role == 1 || $role == 2): ?>
                <a href="<?= $basePath ?>/usuarios" class="btn" style="justify-content: center;">
                    <i class="fas fa-users-cog"></i> Usuários
                </a>
            <?php endif; ?>
            
            <?php if ($role == 1): ?>
                <a href="<?= $basePath ?>/logs" class="btn" style="justify-content: center;">
                    <i class="fas fa-history"></i> Logs
                </a>
            <?php endif; ?>
            
            <a href="<?= $basePath ?>/logout" class="btn btn-danger" style="justify-content: center;">
                <i class="fas fa-sign-out-alt"></i> Sair
            </a>
        <?php else: ?>
            <a href="<?= $basePath ?>/login" class="btn btn-primary" style="justify-content: center;">
                <i class="fas fa-sign-in-alt"></i> Entrar
            </a>
            <a href="<?= $basePath ?>/login/cadastrar" class="btn" style="justify-content: center;">
                <i class="fas fa-user-plus"></i> Criar Conta
            </a>
            <a href="<?= $basePath ?>/sobre" class="btn" style="justify-content: center;">
                <i class="fas fa-info-circle"></i> Sobre
            </a>
            <a href="<?= $basePath ?>/termos" class="btn" style="justify-content: center;">
                <i class="fas fa-file-contract"></i> Termos
            </a>
        <?php endif; ?>
    </div>
</section>

<!-- PERFIS DISPONÍVEIS (somente para admin/master) -->
<?php if ($usuario && $role == 1 && !empty($perfis)): ?>
<section class="section-block animate-in delay-3">
    <h2><i class="fas fa-user-tag"></i> Perfis do Sistema</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem;">
        <?php foreach ($perfis as $perfil): ?>
            <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; text-align: center; border-left: 4px solid var(--color-impact-green);">
                <strong style="display: block; font-size: 1.2rem; color: var(--color-forest-deep);">
                    <?= htmlspecialchars($perfil['perfil']) ?>
                </strong>
                <span style="color: var(--color-text); font-size: 0.85rem;">
                    <?= $perfil['total'] ?> usuário(s)
                </span>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>