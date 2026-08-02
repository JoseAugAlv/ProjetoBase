<?php
// app/Views/termos/termos.php

$tituloPagina = 'Termos de Uso - ' . App::getName();
$cssPagina = 'termos.css';
$basePath = App::getBasePath();
$appName = App::getName();

require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/nav.php';
?>

<section class="termos-section animate-in">
    <div class="container">
        <div class="termos-content">

            <!-- Hero -->
            <div class="termos-hero" style="text-align: center; padding: 2rem 0;">
                <h1 style="font-family: 'Montserrat', sans-serif; font-size: 2.5rem; color: var(--color-forest-deep);">
                    <i class="fas fa-file-contract" style="color: var(--color-impact-green);"></i> Termos de Uso
                </h1>
                <p style="color: var(--color-text);">Leia atentamente os termos e condições de uso do sistema</p>
            </div>

            <!-- Conteúdo -->
            <div class="termos-body" style="max-width: 800px; margin: 0 auto;">

                <div class="termos-alerta" style="background: #fef3c7; padding: 1rem; border-radius: 8px; border-left: 4px solid #f59e0b; margin-bottom: 2rem;">
                    <i class="fas fa-info-circle" style="color: #d97706;"></i>
                    <span><strong>Última atualização:</strong> <?= date('d/m/Y') ?></span>
                </div>

                <!-- Seção 1 -->
                <div class="termos-secao" style="margin-bottom: 2rem;">
                    <h2 style="font-family: 'Montserrat', sans-serif; color: var(--color-forest-deep);"><i class="fas fa-info-circle"></i> 1. Introdução</h2>
                    <p style="color: var(--color-text); line-height: 1.8;">
                        Bem-vindo ao <strong><?= $appName ?></strong>. Ao utilizar este sistema, você concorda com os 
                        termos e condições descritos abaixo.
                    </p>
                </div>

                <!-- Seção 2 -->
                <div class="termos-secao" style="margin-bottom: 2rem;">
                    <h2 style="font-family: 'Montserrat', sans-serif; color: var(--color-forest-deep);"><i class="fas fa-check-circle"></i> 2. Aceitação dos Termos</h2>
                    <p style="color: var(--color-text); line-height: 1.8;">
                        Ao acessar e utilizar o sistema, você declara que leu, compreendeu e concorda 
                        com todos os termos aqui estabelecidos.
                    </p>
                </div>

                <!-- Seção 3 -->
                <div class="termos-secao" style="margin-bottom: 2rem;">
                    <h2 style="font-family: 'Montserrat', sans-serif; color: var(--color-forest-deep);"><i class="fas fa-user-plus"></i> 3. Cadastro e Conta</h2>
                    <p style="color: var(--color-text); line-height: 1.8;">
                        Você se compromete a fornecer informações precisas e manter a confidencialidade de sua senha.
                    </p>
                </div>

                <!-- Seção 4 -->
                <div class="termos-secao" style="margin-bottom: 2rem;">
                    <h2 style="font-family: 'Montserrat', sans-serif; color: var(--color-forest-deep);"><i class="fas fa-cogs"></i> 4. Uso do Sistema</h2>
                    <p style="color: var(--color-text); line-height: 1.8;">
                        O sistema deve ser utilizado apenas para os fins a que se destina. É proibido qualquer uso ilegal ou fraudulento.
                    </p>
                </div>

                <!-- Seção 5 -->
                <div class="termos-secao" style="margin-bottom: 2rem;">
                    <h2 style="font-family: 'Montserrat', sans-serif; color: var(--color-forest-deep);"><i class="fas fa-shield-alt"></i> 5. Privacidade</h2>
                    <p style="color: var(--color-text); line-height: 1.8;">
                        Seus dados pessoais são coletados exclusivamente para as finalidades do sistema.
                    </p>
                </div>

                <!-- Seção 6 -->
                <div class="termos-secao" style="margin-bottom: 2rem;">
                    <h2 style="font-family: 'Montserrat', sans-serif; color: var(--color-forest-deep);"><i class="fas fa-copyright"></i> 6. Propriedade Intelectual</h2>
                    <p style="color: var(--color-text); line-height: 1.8;">
                        Todo o conteúdo do sistema é protegido por direitos autorais.
                    </p>
                </div>

                <!-- Aceitação -->
                <div class="termos-aceite" style="text-align: center; padding: 2rem; background: #f8f9fa; border-radius: 8px; margin-top: 2rem;">
                    <i class="fas fa-check-circle" style="color: var(--color-impact-green); font-size: 3rem;"></i>
                    <h3 style="font-family: 'Montserrat', sans-serif; color: var(--color-forest-deep); margin: 1rem 0;">Ao utilizar o sistema, você concorda com todos os termos acima.</h3>
                    <p style="color: var(--color-text);">Última atualização: <?= date('d/m/Y') ?></p>
                </div>

            </div>

            <!-- Voltar -->
            <div class="termos-voltar" style="text-align: center; padding-top: 2rem; border-top: 2px solid #f0f0f0; margin-top: 2rem;">
                <a href="<?= $basePath ?>/" class="btn">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>

        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>