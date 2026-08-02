<?php
// app/Views/usuarios/primeiro_acesso_pendentes.php

$tituloPagina = 'Primeiro Acesso Pendente - ' . App::getName();
$cssPagina = 'usuarios.css';
$basePath = App::getBasePath();
$appName = App::getName();

require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/nav.php';

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['role'] != 1) {
    header('Location: ' . $basePath . '/');
    exit;
}

if (isset($_SESSION['flash'])) {
    $flash = $_SESSION['flash'];
    echo '<div class="flash-' . $flash['tipo'] . '">' . htmlspecialchars($flash['mensagem']) . '</div>';
    unset($_SESSION['flash']);
}
?>

<section class="usuarios-section animate-in">
    <div class="container">
        <div class="usuarios-content">

            <!-- Hero -->
            <div class="usuarios-hero">
                <div>
                    <h1><i class="fas fa-user-clock" style="color: #f59e0b;"></i> Primeiro Acesso Pendente</h1>
                    <p class="usuarios-subtitle">
                        <i class="fas fa-info-circle"></i> Usuários que ainda não completaram o cadastro inicial
                    </p>
                </div>
                <span class="badge-count">
                    <i class="fas fa-users"></i> <?= $totalPendentes ?? 0 ?> pendente(s)
                </span>
            </div>

            <!-- Ações -->
            <div class="usuarios-actions">
                <a href="<?= $basePath ?>/usuarios" class="btn">
                    <i class="fas fa-arrow-left"></i> Voltar para Usuários
                </a>
                <a href="<?= $basePath ?>/usuarios/criar" class="btn btn-new">
                    <i class="fas fa-user-plus"></i> Cadastrar Novo Usuário
                </a>
            </div>

            <!-- Lista de Pendentes -->
            <?php if (empty($pendentes)): ?>
                <div class="empty-state">
                    <i class="fas fa-check-circle" style="color: var(--color-impact-green);"></i>
                    <h3>Nenhum usuário com primeiro acesso pendente</h3>
                    <p>Todos os usuários já completaram o cadastro inicial.</p>
                </div>
            <?php else: ?>
                <div class="usuarios-table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Perfil</th>
                                <th>Data Cadastro</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pendentes as $usuario): ?>
                                <tr>
                                    <td>#<?= $usuario['id_usuario'] ?></td>
                                    <td><strong><?= htmlspecialchars($usuario['nome']) ?></strong></td>
                                    <td><?= htmlspecialchars($usuario['email']) ?></td>
                                    <td>
                                        <span class="status-badge perfil-<?= $usuario['id_perfil'] ?? 4 ?>">
                                            <?= htmlspecialchars($usuario['nome_perfil'] ?? 'Usuario') ?>
                                        </span>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($usuario['data_criacao'])) ?></td>
                                    <td>
                                        <span class="status-badge pendente">
                                            <i class="fas fa-clock"></i> Pendente
                                        </span>
                                    </td>
                                    <td>
                                        <button onclick="abrirModalResetar(<?= $usuario['id_usuario'] ?>, '<?= addslashes($usuario['nome']) ?>')" class="btn btn-sm btn-warning">
                                            <i class="fas fa-key"></i> Redefinir Senha
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="usuarios-info">
                    <i class="fas fa-info-circle"></i> 
                    <strong><?= $totalPendentes ?? 0 ?></strong> usuário(s) aguardando primeiro acesso.
                </div>
            <?php endif; ?>

            <!-- Voltar -->
            <div class="usuarios-voltar">
                <a href="<?= $basePath ?>/" class="btn">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>

        </div>
    </div>
</section>

<!-- Modal para redefinir senha -->
<div id="modalResetar" class="modal-overlay">
    <div class="modal-box" style="max-width: 500px;">
        <div class="modal-header">
            <h2><i class="fas fa-key" style="color: #f59e0b;"></i> Redefinir Senha</h2>
            <button onclick="fecharModal()" class="modal-close">&times;</button>
        </div>
        <div class="modal-body">
            <p style="margin-bottom: 1rem; color: var(--color-text);">
                <strong>Usuário:</strong> <span id="modalUsuarioNome"></span>
            </p>
            <div class="alert-warning">
                <i class="fas fa-lightbulb"></i> 
                A nova senha deve ter no mínimo 8 caracteres, com letras maiúsculas, minúsculas, números e caracteres especiais.
            </div>
            <form id="formResetarSenha">
                <?= ViewHelper::csrfField() ?>
                <input type="hidden" id="modalIdUsuario" name="id_usuario">
                
                <div class="form-group">
                    <label for="modalNovaSenha">Nova Senha <span class="required">*</span></label>
                    <input type="password" id="modalNovaSenha" name="nova_senha" class="form-control" 
                           placeholder="Digite a nova senha" required minlength="8" 
                           onkeyup="validarSenhaModal()">
                    <div id="modalRequisitosSenha" style="margin-top:5px;"></div>
                </div>

                <div class="form-group">
                    <label for="modalConfirmarSenha">Confirmar Senha <span class="required">*</span></label>
                    <input type="password" id="modalConfirmarSenha" name="confirmar_senha" class="form-control" 
                           placeholder="Digite a nova senha novamente" required minlength="8">
                </div>

                <div class="modal-actions">
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Salvar Nova Senha
                    </button>
                    <button type="button" onclick="fecharModal()" class="btn">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function abrirModalResetar(id, nome) {
    document.getElementById('modalIdUsuario').value = id;
    document.getElementById('modalUsuarioNome').textContent = nome;
    document.getElementById('modalNovaSenha').value = '';
    document.getElementById('modalConfirmarSenha').value = '';
    document.getElementById('modalRequisitosSenha').innerHTML = '';
    document.getElementById('modalResetar').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function fecharModal() {
    document.getElementById('modalResetar').classList.remove('active');
    document.body.style.overflow = 'auto';
}

document.getElementById('modalResetar').addEventListener('click', function(e) {
    if (e.target === this) {
        fecharModal();
    }
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        fecharModal();
    }
});

function validarSenhaModal() {
    var senha = document.getElementById('modalNovaSenha').value;
    var requisitos = document.getElementById('modalRequisitosSenha');
    
    if (senha === '') {
        requisitos.innerHTML = '';
        return;
    }
    
    var html = '<ul style="list-style:none; padding:0; font-size:12px; margin:5px 0;">';
    var ok = senha.length >= 8;
    html += '<li style="color:' + (ok ? 'green' : 'red') + ';">' + (ok ? '✅' : '❌') + ' Mínimo 8 caracteres</li>';
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

document.getElementById('formResetarSenha').addEventListener('submit', function(e) {
    e.preventDefault();
    
    var senha = document.getElementById('modalNovaSenha').value;
    var confirmar = document.getElementById('modalConfirmarSenha').value;
    
    if (senha !== confirmar) {
        Swal.fire({ icon: 'error', title: 'Erro!', text: 'As senhas não coincidem.', confirmButtonColor: '#dc3545' });
        return;
    }
    
    if (senha.length < 8) {
        Swal.fire({ icon: 'error', title: 'Senha fraca!', text: 'A senha deve ter no mínimo 8 caracteres.', confirmButtonColor: '#dc3545' });
        return;
    }
    
    var formData = new FormData(this);
    
    fetch('<?= $basePath ?>/usuarios/resetar-senha-primeiro-acesso', {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(function(response) { return response.json(); })
    .then(function(data) {
        if (data.success) {
            Swal.fire({ icon: 'success', title: 'Senha redefinida!', html: data.message, confirmButtonColor: '#10b981' })
            .then(function() { fecharModal(); location.reload(); });
        } else {
            Swal.fire({ icon: 'error', title: 'Erro!', text: data.message || 'Erro ao redefinir senha.', confirmButtonColor: '#dc3545' });
        }
    })
    .catch(function() {
        Swal.fire({ icon: 'error', title: 'Erro!', text: 'Erro ao processar requisição.', confirmButtonColor: '#dc3545' });
    });
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>