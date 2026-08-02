<?php
// app/Views/sobre/index.php

$tituloPagina = 'Sobre - ' . App::getName();
$cssPagina = 'sobre.css';
$basePath = App::getBasePath();
$appName = App::getName();

require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/nav.php';
?>

<section class="sobre-section animate-in">
    <div class="container">
        <div class="sobre-content">

            <!-- Hero -->
            <div class="sobre-hero" style="text-align: center; padding: 2rem 0;">
                <h1 style="font-family: 'Montserrat', sans-serif; font-size: 2.5rem; color: var(--color-forest-deep);">
                    Sobre o <?= $appName ?>
                </h1>
                <p class="subtitulo" style="color: var(--color-text); font-size: 1.1rem;">
                    Sistema de Gestão de Usuários e Permissões
                </p>
            </div>

            <!-- O que é -->
            <div class="sobre-secao" style="max-width: 800px; margin: 0 auto 2rem;">
                <h2 style="font-family: 'Montserrat', sans-serif; color: var(--color-forest-deep);">O que é o <?= $appName ?>?</h2>
                <p style="color: var(--color-text); line-height: 1.8;">
                    O <?= $appName ?> é um sistema base desenvolvido para gerenciar <strong>usuários, perfis e permissões</strong> 
                    de forma simples e eficiente. Ele foi criado para ser adaptado a qualquer projeto, 
                    servindo como base para sistemas maiores.
                </p>
                <p style="color: var(--color-text); line-height: 1.8;">
                    Com uma estrutura limpa e organizada, o <?= $appName ?> oferece autenticação, 
                    recuperação de senha, verificação de e-mail, gerenciamento de usuários e 
                    controle de permissões baseado em perfis.
                </p>
            </div>

            <!-- Perfis -->
            <div class="sobre-secao" style="max-width: 800px; margin: 0 auto 2rem;">
                <h2 style="font-family: 'Montserrat', sans-serif; color: var(--color-forest-deep);">Perfis do Sistema</h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-top: 1rem;">
                    <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; border-left: 4px solid #f59e0b;">
                        <strong style="color: #f59e0b;">Master</strong>
                        <p style="color: var(--color-text); font-size: 0.9rem; margin: 0.3rem 0 0;">Acesso total ao sistema</p>
                    </div>
                    <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; border-left: 4px solid #3b82f6;">
                        <strong style="color: #3b82f6;">Admin</strong>
                        <p style="color: var(--color-text); font-size: 0.9rem; margin: 0.3rem 0 0;">Gerencia usuários e conteúdo</p>
                    </div>
                    <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; border-left: 4px solid #10b981;">
                        <strong style="color: #10b981;">Operador</strong>
                        <p style="color: var(--color-text); font-size: 0.9rem; margin: 0.3rem 0 0;">Operações básicas</p>
                    </div>
                    <div style="background: #f8f9fa; padding: 1rem; border-radius: 8px; border-left: 4px solid #6b7280;">
                        <strong style="color: #6b7280;">Usuario</strong>
                        <p style="color: var(--color-text); font-size: 0.9rem; margin: 0.3rem 0 0;">Acesso restrito</p>
                    </div>
                </div>
            </div>

            <!-- Tecnologia -->
            <div class="sobre-secao" style="max-width: 800px; margin: 0 auto 2rem;">
                <h2 style="font-family: 'Montserrat', sans-serif; color: var(--color-forest-deep);">Tecnologias</h2>
                <ul style="color: var(--color-text); line-height: 2;">
                    <li><strong>PHP</strong> - Linguagem de programação</li>
                    <li><strong>MySQL</strong> - Banco de dados</li>
                    <li><strong>HTML/CSS/JS</strong> - Interface</li>
                    <li><strong>PHPMailer</strong> - Envio de e-mails</li>
                </ul>
            </div>

            <!-- Funcionalidades -->
            <div class="sobre-secao" style="max-width: 800px; margin: 0 auto 2rem;">
                <h2 style="font-family: 'Montserrat', sans-serif; color: var(--color-forest-deep);">Funcionalidades</h2>
                <ul style="color: var(--color-text); line-height: 2;">
                    <li> Autenticação de usuários</li>
                    <li> Cadastro com verificação de e-mail</li>
                    <li> Recuperação de senha</li>
                    <li> Primeiro acesso</li>
                    <li> Gerenciamento de usuários (CRUD)</li>
                    <li> Controle de permissões por perfil</li>
                    <li> Notificações</li>
                    <li> Logs do sistema</li>
                </ul>
            </div>

            <!-- Voltar -->
            <div class="sobre-voltar" style="text-align: center; padding-top: 2rem; border-top: 2px solid #f0f0f0;">
                <a href="<?= $basePath ?>/" class="btn">
                    <i class="fas fa-arrow-left"></i> Voltar para o início
                </a>
            </div>

        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>