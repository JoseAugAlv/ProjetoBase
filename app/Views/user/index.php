<?php
// app/Views/user/index.php

$tituloPagina = 'Minha Conta - ' . App::getName();
$cssPagina = 'user.css';
$basePath = App::getBasePath();
$appName = App::getName();

$usuarioPerfil = $usuario ?? null;

require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/nav.php';

$usuario = $usuarioPerfil;

if (!isset($_SESSION['usuario'])) {
    header('Location: ' . $basePath . '/login');
    exit;
}

if (isset($_SESSION['flash'])) {
    $flash = $_SESSION['flash'];
    echo '<div class="flash-' . $flash['tipo'] . '">' . htmlspecialchars($flash['mensagem']) . '</div>';
    unset($_SESSION['flash']);
}

if (!isset($usuario) || empty($usuario)) {
    echo '<div class="flash-erro">Erro: Dados do usuario nao encontrados.</div>';
    echo '<a href="' . $basePath . '/" class="btn">Voltar</a>';
    require_once __DIR__ . '/../layouts/footer.php';
    exit;
}

$isAtivo = isset($usuario['ativo']) ? (bool) $usuario['ativo'] : true;
$emailVerificado = isset($usuario['email_verificado']) ? (bool) $usuario['email_verificado'] : false;
$dataNascimentoFormatada = $usuario['data_nascimento_formatada'] ?? 'Nao informada';
$telefoneFormatado = $usuario['telefone_formatado'] ?? 'Nao informado';
$nomePerfil = $usuario['nome_perfil'] ?? 'Usuario';
$statusPerfil = $usuario['status_perfil'] ?? 'Nao informado';
?>

<section class="profile-section animate-in">
    <div class="profile-container">
        <div class="profile-card">
            <!-- Cabeçalho do Perfil -->
            <div class="profile-header">
                <div class="profile-avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="profile-info">
                    <h2><?= htmlspecialchars($usuario['nome']) ?></h2>
                    <p class="profile-email"><?= htmlspecialchars($usuario['email']) ?></p>
                    <div class="profile-badges">
                        <span class="profile-badge perfil-<?= strtolower($nomePerfil) ?>">
                            <?= htmlspecialchars($nomePerfil) ?>
                        </span>
                        <span class="badge <?= $isAtivo ? 'badge-success' : 'badge-danger' ?>">
                            <?= $isAtivo ? 'Ativo' : 'Inativo' ?>
                        </span>
                        <span class="badge <?= $emailVerificado ? 'badge-info' : 'badge-warning' ?>">
                            <?= $emailVerificado ? 'Email Verificado' : 'Email Nao Verificado' ?>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Dados do Usuário -->
            <div class="profile-body">
                <div class="profile-grid">
                    <div class="profile-item">
                        <span class="profile-label">Nome</span>
                        <span class="profile-value"><?= htmlspecialchars($usuario['nome']) ?></span>
                    </div>
                    <div class="profile-item">
                        <span class="profile-label">E-mail</span>
                        <span class="profile-value"><?= htmlspecialchars($usuario['email']) ?></span>
                    </div>
                    <div class="profile-item">
                        <span class="profile-label">Telefone</span>
                        <span class="profile-value"><?= htmlspecialchars($telefoneFormatado) ?></span>
                    </div>
                    <div class="profile-item">
                        <span class="profile-label">Data de Nascimento</span>
                        <span class="profile-value"><?= $dataNascimentoFormatada ?></span>
                    </div>
                    <div class="profile-item">
                        <span class="profile-label">Perfil</span>
                        <span class="profile-value"><?= htmlspecialchars($nomePerfil) ?></span>
                    </div>
                    <div class="profile-item">
                        <span class="profile-label">Status do Perfil</span>
                        <span class="profile-value"><?= htmlspecialchars($statusPerfil) ?></span>
                    </div>
                </div>

                <!-- Ações -->
                <div class="profile-actions">
                    <a href="<?= $basePath ?>/user/editar" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Editar Dados
                    </a>
                    <a href="<?= $basePath ?>/" class="btn">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>