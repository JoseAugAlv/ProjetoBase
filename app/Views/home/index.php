<?php
// app/Views/home/index.php

$tituloPagina = 'ProjetoBase - Sistema Base em PHP';
$cssPagina = 'home.css';
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/nav.php';

$usuario = $_SESSION['usuario'] ?? null;
$role = $usuario['role'] ?? null;
$nome = $usuario['nome'] ?? 'Visitante';
$basePath = App::getBasePath();
$appName = App::getName();

// Estatísticas para demonstração
$totalUsuarios = 4; // Exemplo
$totalModulos = 7;
$totalPerfis = 4;
?>

<!-- ============================================================ -->
<!-- HERO SECTION                                                -->
<!-- ============================================================ -->
<section class="hero-section animate-in">
    <div class="hero-overlay"></div>
    <div class="hero-container">
        <div class="hero-badge">
            <span class="badge-version">v1.0.0</span>
            <span class="badge-status">Estável</span>
        </div>
        <h1>
            <?php if ($usuario): ?>
                Bem-vindo, <span class="highlight"><?= htmlspecialchars($nome) ?></span>!
            <?php else: ?>
                <span class="highlight">ProjetoBase</span>
            <?php endif; ?>
        </h1>
        <p class="hero-description">
            Sistema PHP com arquitetura <strong>MVC</strong> e 
            <strong>Programação Orientada a Objetos</strong>.
            Base pronta para desenvolvimento de sistemas web.
        </p>
        <div class="hero-buttons">
            <?php if ($usuario): ?>
                <a href="<?= $basePath ?>/dashboard" class="btn btn-primary">
                    <i class="fas fa-chart-pie"></i> Dashboard
                </a>
                <a href="<?= $basePath ?>/user" class="btn btn-outline">
                    <i class="fas fa-user"></i> Minha Conta
                </a>
            <?php else: ?>
                <a href="<?= $basePath ?>/login" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Entrar
                </a>
                <a href="<?= $basePath ?>/login/cadastrar" class="btn btn-outline">
                    <i class="fas fa-user-plus"></i> Criar Conta
                </a>
                <a href="<?= $basePath ?>/tutorial" class="btn btn-secondary">
                    <i class="fas fa-graduation-cap"></i> Tutorial
                </a>
            <?php endif; ?>
        </div>
        
        <!-- Badge GitHub -->
        <div class="hero-github">
            <a href="https://github.com/JoseAugAlv/ProjetoBase" target="_blank" rel="noopener noreferrer" class="github-link">
                <svg height="20" width="20" viewBox="0 0 16 16" fill="currentColor">
                    <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0016 8c0-4.42-3.58-8-8-8z"/>
                </svg>
                <span>GitHub</span>
                <span class="github-stars">
                    <i class="fas fa-star"></i> Star
                </span>
            </a>
        </div>
    </div>
</section>

<!-- ============================================================ -->
<!-- SOBRE O PROJETO                                             -->
<!-- ============================================================ -->
<section class="section-block animate-in delay-1">
    <div class="container">
        <div class="section-header">
            <h2>Sobre o ProjetoBase</h2>
            <p>Uma base sólida para seus projetos PHP</p>
        </div>

        <div class="about-grid">
            <div class="about-card">
                <div class="about-icon">
                    <i class="fas fa-rocket"></i>
                </div>
                <h3>Pronto para uso</h3>
                <p>
                    Sistema já configurado com autenticação, CRUD de usuários, 
                    controle de permissões e muito mais. Comece a desenvolver 
                    imediatamente.
                </p>
            </div>

            <div class="about-card">
                <div class="about-icon">
                    <i class="fas fa-code"></i>
                </div>
                <h3>Arquitetura MVC</h3>
                <p>
                    Estrutura organizada seguindo o padrão Model-View-Controller 
                    com Programação Orientada a Objetos para maior manutenibilidade.
                </p>
            </div>

            <div class="about-card">
                <div class="about-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Segurança Integrada</h3>
                <p>
                    Proteção contra CSRF, validação de senha, sanitização de dados, 
                    logs de auditoria e autenticação segura por sessão.
                </p>
            </div>

            <div class="about-card">
                <div class="about-icon">
                    <i class="fas fa-puzzle-piece"></i>
                </div>
                <h3>Modular e Extensível</h3>
                <p>
                    Sistema de módulos para ativar/desativar funcionalidades. 
                    Menu dinâmico configurável. Fácil de estender e personalizar.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================ -->
<!-- RECURSOS DO SISTEMA                                         -->
<!-- ============================================================ -->
<section class="section-block animate-in delay-2">
    <div class="container">
        <div class="section-header">
            <h2>Recursos do Sistema</h2>
            <p>Tudo que você precisa para começar</p>
        </div>

        <div class="features-grid">
            <!-- Autenticação -->
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <div class="feature-content">
                    <h4>Autenticação Completa</h4>
                    <p>Login, cadastro, recuperação de senha, verificação de e-mail e primeiro acesso.</p>
                    <span class="feature-badge">Pronto</span>
                </div>
            </div>

            <!-- Gerenciamento de Usuários -->
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-users-cog"></i>
                </div>
                <div class="feature-content">
                    <h4>Gerenciamento de Usuários</h4>
                    <p>CRUD completo com controle de perfis: Master, Admin, Operador e Usuario.</p>
                    <span class="feature-badge">Pronto</span>
                </div>
            </div>

            <!-- Notificações -->
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-bell"></i>
                </div>
                <div class="feature-content">
                    <h4>Sistema de Notificações</h4>
                    <p>Notificações em tempo real, marcação de leitura individual e em massa.</p>
                    <span class="feature-badge">Pronto</span>
                </div>
            </div>

            <!-- Logs -->
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-history"></i>
                </div>
                <div class="feature-content">
                    <h4>Logs de Auditoria</h4>
                    <p>Registro de todas as ações importantes com filtros e busca.</p>
                    <span class="feature-badge">Pronto</span>
                </div>
            </div>

            <!-- Backup -->
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-database"></i>
                </div>
                <div class="feature-content">
                    <h4>Backup do Banco</h4>
                    <p>Exportação do banco de dados em SQL, download e exclusão de backups.</p>
                    <span class="feature-badge">Pronto</span>
                </div>
            </div>

            <!-- Relatórios -->
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="feature-content">
                    <h4>Relatórios</h4>
                    <p>Exportação de dados em PDF e Excel com gráficos interativos.</p>
                    <span class="feature-badge">Pronto</span>
                </div>
            </div>

            <!-- Menu Dinâmico -->
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-bars"></i>
                </div>
                <div class="feature-content">
                    <h4>Menu Dinâmico</h4>
                    <p>Configuração via arquivo PHP com submenus e controle por perfil.</p>
                    <span class="feature-badge">Pronto</span>
                </div>
            </div>

            <!-- API -->
            <div class="feature-item">
                <div class="feature-icon">
                    <i class="fas fa-plug"></i>
                </div>
                <div class="feature-content">
                    <h4>API REST</h4>
                    <p>Estrutura pronta para desenvolvimento de API (desativável via módulo).</p>
                    <span class="feature-badge feature-badge-optional">Opcional</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================ -->
<!-- ESTATÍSTICAS                                               -->
<!-- ============================================================ -->
<section class="section-block animate-in delay-3">
    <div class="container">
        <div class="stats-grid-home">
            <div class="stat-box-home">
                <span class="stat-number"><?= $totalUsuarios ?></span>
                <span class="stat-label">Usuários</span>
            </div>
            <div class="stat-box-home">
                <span class="stat-number"><?= $totalPerfis ?></span>
                <span class="stat-label">Perfis</span>
            </div>
            <div class="stat-box-home">
                <span class="stat-number"><?= $totalModulos ?></span>
                <span class="stat-label">Módulos</span>
            </div>
            <div class="stat-box-home">
                <span class="stat-number">100%</span>
                <span class="stat-label">Cobertura</span>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================ -->
<!-- COMO COMEÇAR                                               -->
<!-- ============================================================ -->
<section class="section-block animate-in delay-4">
    <div class="container">
        <div class="section-header">
            <h2>Como Começar</h2>
            <p>Passos para iniciar com o ProjetoBase</p>
        </div>

        <div class="steps-container">
            <div class="step-item">
                <div class="step-number">1</div>
                <div class="step-content">
                    <h4>Clone o Repositório</h4>
                    <div class="code-snippet">
                        <code>git clone https://github.com/JoseAugAlv/ProjetoBase.git</code>
                    </div>
                    <p>Faça o download do projeto para sua máquina.</p>
                </div>
            </div>

            <div class="step-item">
                <div class="step-number">2</div>
                <div class="step-content">
                    <h4>Configure o .env</h4>
                    <p>Copie o arquivo <code>.env.example</code> para <code>.env</code> e configure:</p>
                    <ul>
                        <li>Nome do sistema</li>
                        <li>Conexão com banco de dados</li>
                        <li>Configurações de e-mail (SMTP)</li>
                    </ul>
                </div>
            </div>

            <div class="step-item">
                <div class="step-number">3</div>
                <div class="step-content">
                    <h4>Execute o Banco de Dados</h4>
                    <p>Importe o script <code>ProjetoBase_bd.sql</code> no seu MySQL.</p>
                    <div class="code-snippet">
                        <code>mysql -u root -p &lt; ProjetoBase_bd.sql</code>
                    </div>
                </div>
            </div>

            <div class="step-item">
                <div class="step-number">4</div>
                <div class="step-content">
                    <h4>Acesse o Sistema</h4>
                    <p>Acesse pelo navegador e faça login com os dados de teste:</p>
                    <div class="code-snippet">
                        <code>master@projetobase.com / 123</code>
                        <br>
                        <code>admin@projetobase.com / 123</code>
                    </div>
                </div>
            </div>
        </div>

        <div class="cta-container">
            <a href="https://github.com/JoseAugAlv/ProjetoBase" target="_blank" rel="noopener noreferrer" class="btn btn-github-large">
                <i class="fab fa-github"></i> Ver no GitHub
            </a>
            <a href="<?= $basePath ?>/tutorial" class="btn btn-primary">
                <i class="fas fa-graduation-cap"></i> Ler Tutorial
            </a>
        </div>
    </div>
</section>

<!-- ============================================================ -->
<!-- FOOTER COM CRÉDITOS                                        -->
<!-- ============================================================ -->
<footer class="home-footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-brand">
                <h3><?= strtoupper($appName) ?>.</h3>
                <p>
                    Sistema base em PHP com arquitetura MVC e Programação Orientada a Objetos.
                    Desenvolvido para servir como base para projetos web.
                </p>
            </div>

            <div class="footer-links">
                <div class="footer-col">
                    <h4>Navegação</h4>
                    <ul>
                        <li><a href="<?= $basePath ?>/"><i class="fas fa-chevron-right"></i> Início</a></li>
                        <li><a href="<?= $basePath ?>/sobre"><i class="fas fa-chevron-right"></i> Sobre</a></li>
                        <li><a href="<?= $basePath ?>/termos"><i class="fas fa-chevron-right"></i> Termos</a></li>
                        <li><a href="<?= $basePath ?>/tutorial"><i class="fas fa-chevron-right"></i> Tutorial</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Links Úteis</h4>
                    <ul>
                        <li><a href="https://github.com/JoseAugAlv/ProjetoBase" target="_blank"><i class="fab fa-github"></i> GitHub</a></li>
                        <li><a href="https://josealvesdev.com/" target="_blank"><i class="fas fa-briefcase"></i> Portfólio</a></li>
                        <li><a href="https://www.instagram.com/jose.asx_" target="_blank"><i class="fab fa-instagram"></i> Instagram</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer-divider"></div>

        <!-- ============================================================ -->
        <!-- CRÉDITOS DO DESENVOLVEDOR                                  -->
        <!-- ============================================================ -->
        <div class="footer-bottom">
            <div class="footer-bottom-content">
                <p>
                    &copy; <?= date('Y') ?> <strong><?= $appName ?></strong>. Todos os direitos reservados.
                </p>
                
                <a href="https://josealvesdev.com/" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="footer-credits-btn">
                    <span class="credit-code">&lt;/&gt;</span>
                    <span class="credit-name">Jose Augusto Alves</span>
                    <i class="fas fa-arrow-right credit-arrow"></i>
                </a>
            </div>
        </div>
    </div>
</footer>
<!-- ============================================================ -->
<!-- SCRIPTS                                                    -->
<!-- ============================================================ -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ==========================================
    // ANIMAÇÃO DE ENTRADA AO SCROLL
    // ==========================================
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, {
        threshold: 0.1
    });

    document.querySelectorAll('.animate-in').forEach(function(el) {
        observer.observe(el);
    });

    // ==========================================
    // CONTADOR DE ESTRELAS DO GITHUB (simulado)
    // ==========================================
    const starCount = document.querySelector('.github-stars');
    if (starCount) {
        // Você pode implementar uma chamada à API do GitHub aqui
        // para buscar o número real de estrelas
        console.log('⭐ GitHub star counter ready');
    }
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>