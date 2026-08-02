<?php
// app/Views/auth/index.php

$tituloPagina = 'Login - ' . App::getName();
$cssPagina = 'login.css';
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/nav.php';
require_once __DIR__ . '/../../Helpers/ViewHelper.php';

$basePath = App::getBasePath();
$appName = App::getName();

if (isset($_SESSION['flash'])): ?>
    <div class="flash-<?= $_SESSION['flash']['tipo'] ?>">
        <?= htmlspecialchars($_SESSION['flash']['mensagem']) ?>
    </div>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<section class="auth-section animate-in">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h2>Bem-vindo de volta</h2>
                <p>Faça login para acessar sua conta</p>
            </div>
            
            <form method="POST" action="<?= $basePath ?>/login" class="auth-form">
                <?= ViewHelper::csrfField() ?>
                
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" class="form-control" 
                        placeholder="Digite seu e-mail" required>
                </div>
                
                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" class="form-control" 
                        placeholder="••••••••" required>
                </div>
                
                <div class="auth-options">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember" value="1">
                        <span>Lembrar de mim</span>
                    </label>
                    <a href="<?= $basePath ?>/auth/esqueci-senha" class="auth-link">Esqueceu a senha?</a>
                </div>
                
                <button type="submit" class="btn btn-primary btn-full">Entrar</button>
            </form>
            
            <div class="auth-footer">
                <p>Não tem uma conta? <a href="<?= $basePath ?>/login/cadastrar">Criar Conta</a></p>
            </div>
            
            <?php if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1'): ?>
            <div class="auth-dev" style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid #e9ecef;">
                <h4 style="font-size: 0.9rem; color: #6c757d;">🔧 Login Rápido (DEV)</h4>
                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    <button type="button" class="btn btn-sm" onclick="loginRapido('master@projetobase.com')" style="background: #f59e0b; color: #fff;">Master</button>
                    <button type="button" class="btn btn-sm" onclick="loginRapido('admin@projetobase.com')" style="background: #3b82f6; color: #fff;">Admin</button>
                    <button type="button" class="btn btn-sm" onclick="loginRapido('operador@projetobase.com')" style="background: #10b981; color: #fff;">Operador</button>
                    <button type="button" class="btn btn-sm" onclick="loginRapido('usuario@projetobase.com')" style="background: #6b7280; color: #fff;">Usuario</button>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<script>
function loginRapido(email) {
    document.getElementById('email').value = email;
    document.getElementById('senha').value = '123';
}
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>