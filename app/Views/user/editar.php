<?php
// app/Views/user/editar.php

$tituloPagina = 'Editar Conta - ' . App::getName();
$cssPagina = 'user.css';
$basePath = App::getBasePath();

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
?>

<section class="profile-section animate-in">
    <div class="profile-container">
        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-avatar">
                    <i class="fas fa-user-edit"></i>
                </div>
                <div class="profile-info">
                    <h2>Editar Conta</h2>
                    <p class="profile-email">Atualize seus dados pessoais</p>
                </div>
            </div>

            <div class="profile-body">
                <form action="<?= $basePath ?>/user/atualizar" method="POST" onsubmit="return validarSenha()">
                    <?= ViewHelper::csrfField() ?>
                    
                    <div class="profile-grid">
                        <div class="profile-item form-group full-width">
                            <label for="nome">Nome completo <span class="required">*</span></label>
                            <input type="text" id="nome" name="nome" class="form-control" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
                        </div>
                        
                        <div class="profile-item form-group full-width">
                            <label for="email">E-mail <span class="required">*</span></label>
                            <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($usuario['email']) ?>" required>
                        </div>
                        
                        <div class="profile-item form-group">
                            <label for="telefone">Telefone</label>
                            <input type="text" id="telefone" name="telefone" class="form-control" value="<?= htmlspecialchars($usuario['telefone'] ?? '') ?>" placeholder="(00) 00000-0000">
                        </div>
                        
                        <div class="profile-item form-group">
                            <label for="data_nascimento">Data de Nascimento</label>
                            <input type="date" id="data_nascimento" name="data_nascimento" class="form-control" value="<?= $usuario['data_nascimento'] ?? '' ?>">
                        </div>
                    </div>

                    <!-- Alterar Senha -->
                    <div class="profile-section-divider">
                        <h3><i class="fas fa-lock"></i> Alterar Senha</h3>
                        <p class="form-help">Deixe em branco para manter a senha atual</p>
                    </div>

                    <div class="profile-grid">
                        <div class="profile-item form-group">
                            <label for="senha">Nova Senha</label>
                            <input type="password" id="senha" name="senha" class="form-control" placeholder="Mínimo 6 caracteres" minlength="6" onkeyup="atualizarRequisitosSenha()">
                            <div id="requisitos_senha" class="requisitos-senha"></div>
                        </div>
                        
                        <div class="profile-item form-group">
                            <label for="senha_confirm">Confirmar Nova Senha</label>
                            <input type="password" id="senha_confirm" name="senha_confirm" class="form-control" placeholder="Repita a senha" minlength="6">
                        </div>
                    </div>

                    <div class="profile-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Salvar Alterações
                        </button>
                        <a href="<?= $basePath ?>/user" class="btn">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
function validarSenha() {
    var senha = document.getElementById('senha').value;
    var senhaConfirm = document.getElementById('senha_confirm').value;
    
    if (senha === '' && senhaConfirm === '') { return true; }
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
    if (senha === '') { requisitos.innerHTML = ''; return; }
    var html = '<ul class="requisitos-list">';
    var checks = [
        { test: senha.length >= 6, text: 'Mínimo 6 caracteres' },
        { test: /[A-Z]/.test(senha), text: 'Letra maiúscula' },
        { test: /[a-z]/.test(senha), text: 'Letra minúscula' },
        { test: /[0-9]/.test(senha), text: 'Número' },
        { test: /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(senha), text: 'Caractere especial' }
    ];
    checks.forEach(function(item) {
        html += '<li class="' + (item.test ? 'ok' : 'erro') + '">' + (item.test ? '✅' : '❌') + ' ' + item.text + '</li>';
    });
    html += '</ul>';
    requisitos.innerHTML = html;
}

document.addEventListener('DOMContentLoaded', function() {
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