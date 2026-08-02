<?php
// app/Views/auth/primeiro_acesso.php

$tituloPagina = 'Primeiro Acesso - ' . App::getName();
$cssPagina = 'auth.css';
$basePath = App::getBasePath();
$appName = App::getName();

require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/nav.php';

if (!isset($_SESSION['primeiro_acesso'])) {
    header('Location: ' . $basePath . '/login');
    exit;
}

$dados = $_SESSION['primeiro_acesso'];
?>

<section class="auth-section animate-in">
    <div class="auth-container">
        <div class="auth-card" style="max-width: 550px;">
            <div class="auth-header">
                <h2>👋 Primeiro Acesso</h2>
                <p>Complete seu cadastro para acessar o sistema</p>
            </div>

            <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border-left: 4px solid #10b981;">
                <p style="margin: 0; font-size: 0.95rem;">
                    <strong>Bem-vindo, <?= htmlspecialchars($dados['nome']) ?>!</strong>
                    <br>Complete os dados abaixo para ativar sua conta.
                </p>
            </div>

            <form action="<?= $basePath ?>/auth/completar-primeiro-acesso" method="POST" class="auth-form" onsubmit="return validarFormulario()">
                <?= ViewHelper::csrfField() ?>
                <input type="hidden" name="id_usuario" value="<?= $dados['id_usuario'] ?>">

                <!-- Nome (apenas exibição) -->
                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($dados['nome']) ?>" disabled style="background: #f0f0f0;">
                </div>

                <!-- Email (obrigatório) -->
                <div class="form-group">
                    <label for="email">E-mail <span class="required">*</span></label>
                    <input type="email" id="email" name="email" class="form-control" 
                           placeholder="Digite seu e-mail válido" 
                           value="<?= htmlspecialchars($dados['email_atual'] ?? '') ?>" 
                           required>
                    <span class="form-help">Você receberá um e-mail de verificação.</span>
                </div>

                <!-- Nova Senha -->
                <div class="form-group">
                    <label for="senha">Nova Senha <span class="required">*</span></label>
                    <input type="password" id="senha" name="senha" class="form-control" 
                           placeholder="Mínimo 6 caracteres" required minlength="6" 
                           onkeyup="atualizarRequisitosSenha()">
                    <div id="requisitos_senha" style="margin-top:5px;"></div>
                </div>

                <div class="form-group">
                    <label for="senha_confirm">Confirmar Senha <span class="required">*</span></label>
                    <input type="password" id="senha_confirm" name="senha_confirm" class="form-control" 
                           placeholder="Repita a senha" required minlength="6">
                </div>

                <!-- Data de Nascimento -->
                <div class="form-group">
                    <label for="data_nascimento">Data de Nascimento <span class="required">*</span></label>
                    <input type="date" id="data_nascimento" name="data_nascimento" class="form-control" required>
                    <span class="form-help">Você deve ter pelo menos 12 anos.</span>
                </div>

                <button type="submit" class="btn btn-primary btn-full">
                    <i class="fas fa-check-circle"></i> Completar Cadastro
                </button>
            </form>

            <div class="auth-footer">
                <p><a href="<?= $basePath ?>/logout">Sair</a></p>
            </div>
        </div>
    </div>
</section>

<script>
function validarFormulario() {
    var senha = document.getElementById('senha').value;
    var senhaConfirm = document.getElementById('senha_confirm').value;
    var email = document.getElementById('email').value;
    var dataNasc = document.getElementById('data_nascimento').value;
    
    if (senha !== senhaConfirm) {
        Swal.fire({ icon: 'error', title: 'Erro!', text: 'As senhas não coincidem!', confirmButtonColor: '#dc3545' });
        return false;
    }
    if (senha.length < 6) {
        Swal.fire({ icon: 'error', title: 'Senha fraca!', text: 'A senha deve ter no mínimo 6 caracteres.', confirmButtonColor: '#dc3545' });
        return false;
    }
    if (!email) {
        Swal.fire({ icon: 'error', title: 'E-mail obrigatório!', text: 'Digite um e-mail válido.', confirmButtonColor: '#dc3545' });
        return false;
    }
    if (dataNasc) {
        var hoje = new Date();
        var nasc = new Date(dataNasc);
        var idade = hoje.getFullYear() - nasc.getFullYear();
        var m = hoje.getMonth() - nasc.getMonth();
        if (m < 0 || (m === 0 && hoje.getDate() < nasc.getDate())) { idade--; }
        if (idade < 12) {
            Swal.fire({ icon: 'error', title: 'Idade mínima!', text: 'Você deve ter pelo menos 12 anos.', confirmButtonColor: '#dc3545' });
            return false;
        }
    }
    return true;
}

function atualizarRequisitosSenha() {
    var senha = document.getElementById('senha').value;
    var requisitos = document.getElementById('requisitos_senha');
    if (senha === '') { requisitos.innerHTML = ''; return; }
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
    var hoje = new Date();
    var dataMax = new Date(hoje.getFullYear() - 12, hoje.getMonth(), hoje.getDate());
    document.getElementById('data_nascimento').setAttribute('max', dataMax.toISOString().split('T')[0]);
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>