<?php
// app/Views/auth/criar.php

$tituloPagina = 'Criar Conta - ' . App::getName();
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
        <div class="auth-card">
            <div class="auth-header">
                <h2>Criar Conta</h2>
                <p>Preencha os dados para se cadastrar</p>
            </div>

            <form action="<?= $basePath ?>/login/salvar" method="POST" class="auth-form" onsubmit="return validarFormulario()">
                <?= ViewHelper::csrfField() ?>
                
                <div class="auth-grid">
                    <div class="form-group form-group-full">
                        <label for="nome">Nome completo <span class="required">*</span></label>
                        <input type="text" id="nome" name="nome" class="form-control" placeholder="Seu nome completo" required>
                    </div>
                    
                    <div class="form-group form-group-full">
                        <label for="email">E-mail <span class="required">*</span></label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="seu@email.com" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="senha">Senha <span class="required">*</span></label>
                        <input type="password" id="senha" name="senha" class="form-control" placeholder="Mínimo 6 caracteres" required minlength="6" onkeyup="atualizarRequisitosSenha()">
                        <div id="requisitos_senha" style="margin-top:5px;"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="senha_confirm">Confirmar Senha <span class="required">*</span></label>
                        <input type="password" id="senha_confirm" name="senha_confirm" class="form-control" placeholder="Repita a senha" required minlength="6">
                    </div>
                    
                    <div class="form-group">
                        <label for="telefone">Telefone</label>
                        <input type="text" id="telefone" name="telefone" class="form-control" placeholder="(00) 00000-0000" maxlength="15">
                    </div>
                    
                    <div class="form-group">
                        <label for="data_nascimento">Data de Nascimento</label>
                        <input type="date" id="data_nascimento" name="data_nascimento" class="form-control">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-full">Cadastrar</button>
            </form>

            <div class="auth-footer">
                <p>Já tem conta? <a href="<?= $basePath ?>/login">Faça login</a></p>
            </div>
        </div>
    </div>
</section>

<script>
function validarFormulario() {
    var senha = document.getElementById('senha').value;
    var senhaConfirm = document.getElementById('senha_confirm').value;
    
    if (senha !== senhaConfirm) {
        Swal.fire({ icon: 'error', title: 'Erro!', text: 'As senhas não coincidem!', confirmButtonColor: '#dc3545' });
        return false;
    }
    
    if (senha.length < 6) {
        Swal.fire({ icon: 'error', title: 'Senha fraca!', text: 'A senha deve ter no mínimo 6 caracteres.', confirmButtonColor: '#dc3545' });
        return false;
    }
    
    return true;
}

function atualizarRequisitosSenha() {
    var senha = document.getElementById('senha').value;
    var requisitos = document.getElementById('requisitos_senha');
    
    if (senha === '') {
        requisitos.innerHTML = '';
        return;
    }
    
    var html = '<ul style="list-style:none; padding:0; font-size:12px; margin:5px 0;">';
    var ok = senha.length >= 6;
    html += '<li style="color:' + (ok ? 'green' : 'red') + ';">' + (ok ? '✅' : '❌') + ' Mínimo 6 caracteres</li>';
    ok = /[A-Z]/.test(senha);
    html += '<li style="color:' + (ok ? 'green' : 'red') + ';">' + (ok ? '✅' : '❌') + ' Letra maiúscula</li>';
    ok = /[a-z]/.test(senha);
    html += '<li style="color:' + (ok ? 'green' : 'red') + ';">' + (ok ? '✅' : '❌') + ' Letra minúscula</li>';
    ok = /[0-9]/.test(senha);
    html += '<li style="color:' + (ok ? 'green' : 'red') + ';">' + (ok ? '✅' : '❌') + ' Número</li>';
    ok = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(senha);
    html += '<li style="color:' + (ok ? 'green' : 'red') + ';">' + (ok ? '✅' : '❌') + ' Caractere especial</li>';
    html += '</ul>';
    requisitos.innerHTML = html;
}

document.addEventListener('DOMContentLoaded', function() {
    // Máscara de telefone
    document.getElementById('telefone').addEventListener('input', function(e) {
        var valor = e.target.value.replace(/\D/g, '');
        if (valor.length === 0) { e.target.value = ''; return; }
        var valorFormatado = '';
        if (valor.length <= 2) { valorFormatado = '(' + valor; }
        else if (valor.length <= 6) { valorFormatado = '(' + valor.substring(0, 2) + ') ' + valor.substring(2); }
        else if (valor.length <= 10) { valorFormatado = '(' + valor.substring(0, 2) + ') ' + valor.substring(2, 6) + '-' + valor.substring(6); }
        else { valorFormatado = '(' + valor.substring(0, 2) + ') ' + valor.substring(2, 7) + '-' + valor.substring(7, 11); }
        e.target.value = valorFormatado;
    });
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>