<?php
// app/Views/auth/esqueci_senha.php

$tituloPagina = 'Esqueci a Senha - ' . App::getName();
$cssPagina = 'auth.css';
$basePath = App::getBasePath();
$appName = App::getName();

require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/nav.php';

if (isset($_SESSION['flash'])): ?>
    <div class="flash-<?= $_SESSION['flash']['tipo'] ?>">
        <?= htmlspecialchars($_SESSION['flash']['mensagem']) ?>
    </div>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<section class="auth-section animate-in">
    <div class="auth-container">
        <div class="auth-card" style="max-width: 500px;">
            <div class="auth-header">
                <h2>Esqueci a Senha</h2>
                <p>Digite seu e-mail para receber as instruções</p>
            </div>
            
            <form method="POST" action="<?= $basePath ?>/auth/enviar-token" class="auth-form">
                <?= ViewHelper::csrfField() ?>
                
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="seu@email.com" required>
                </div>
                
                <button type="submit" class="btn btn-primary btn-full">Enviar Instruções</button>
            </form>
            
            <div class="auth-footer">
                <p><a href="<?= $basePath ?>/login">Voltar para o login</a></p>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>