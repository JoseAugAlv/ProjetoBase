<?php
// app/Views/auth/verificar.php

$tituloPagina = 'Verificação de E-mail - ' . App::getName();
$cssPagina = 'auth.css';
$basePath = App::getBasePath();
$appName = App::getName();

require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/nav.php';

$status = $_GET['status'] ?? '';
$mensagem = $_GET['mensagem'] ?? '';

$isSuccess = $status === 'sucesso';
$isError = $status === 'erro' || empty($status);
?>

<section class="auth-section animate-in">
    <div class="auth-container">
        <div class="auth-card" style="text-align: center; max-width: 500px;">

            <?php if ($isSuccess): ?>
                <div style="font-size: 4rem; color: #10b981; margin-bottom: 1rem;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h1 style="color: #065f46; margin-bottom: 0.5rem;">E-mail Verificado!</h1>
                <p style="color: var(--color-text); margin-bottom: 1.5rem;">
                    Seu e-mail foi verificado com sucesso. Agora você já pode fazer login na sua conta.
                </p>
                <a href="<?= $basePath ?>/login" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Fazer Login
                </a>
            <?php else: ?>
                <div style="font-size: 4rem; color: #ef4444; margin-bottom: 1rem;">
                    <i class="fas fa-times-circle"></i>
                </div>
                <h1 style="color: #991b1b; margin-bottom: 0.5rem;">Erro na Verificação</h1>
                <p style="color: var(--color-text); margin-bottom: 1.5rem;">
                    <?= htmlspecialchars($mensagem ?? 'Token inválido ou expirado.') ?>
                </p>
                <p style="color: var(--color-text); font-size: 0.9rem; margin-bottom: 1.5rem;">
                    <i class="fas fa-lightbulb"></i> O link de verificação é válido por 24 horas.
                </p>
                <div style="display: flex; gap: 0.8rem; justify-content: center; flex-wrap: wrap;">
                    <a href="<?= $basePath ?>/login" class="btn">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>