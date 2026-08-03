<?php
// ============================================================
// ARQUIVO: app/Views/tutorial/index.php
// ============================================================
// TUTORIAL COMPLETO DO PROJETOBASE
// ============================================================

// ============================================================
// 1. CONFIGURAÇÃO DA PÁGINA
// ============================================================

$tituloPagina = 'Tutorial Completo - ' . App::getName();
$cssPagina = 'tutorial.css';

require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/nav.php';

$basePath = App::getBasePath();
$appName = App::getName();
?>

<!-- ============================================================ -->
<!-- SEÇÃO 1: BANNER PRINCIPAL                                   -->
<!-- ============================================================ -->
<section class="tutorial-banner animate-in">
    <div class="container">
        <div class="banner-content">
            <div class="banner-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <h1 class="banner-title">
                TUTORIAL <span>COMPLETO</span>
            </h1>
            <p class="banner-subtitle">
                <?= strtoupper($appName) ?> • POO + MVC
            </p>
            <p class="banner-description">
                Guia do Sistema ProjetoBase - Implementação Passo a Passo
            </p>

            <!-- Botão de Créditos -->
            <div class="footer-credits">
                <a href="https://josealvesdev.com/" target="_blank" rel="noopener noreferrer" class="btn-credits large">
                    <span class="credit-text">Criado e pensado por</span>
                    <span class="credit-name">
                        <span class="code-tag">&lt;/&gt;</span>
                        Jose Augusto Alves
                    </span>
                    <span class="credit-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </span>
                </a>
            </div>

            <!-- Botão GitHub -->
            <div class="footer-github" style="margin-top: 0.8rem;">
                <a href="https://github.com/JoseAugAlv/ProjetoBase" target="_blank" rel="noopener noreferrer" class="btn-github">
                    <span class="github-icon">
                        <svg height="20" width="20" viewBox="0 0 16 16" fill="currentColor" style="display:inline-block;vertical-align:middle;">
                            <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0016 8c0-4.42-3.58-8-8-8z"/>
                        </svg>
                    </span>
                    <span class="github-text">Baixar Projeto no GitHub</span>
                    <span class="github-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================ -->
<!-- SEÇÃO 2: ÍNDICE                                             -->
<!-- ============================================================ -->
<section class="tutorial-section animate-in delay-1">
    <div class="container">
        <div class="section-header">
            <h2>
                <i class="fas fa-list-ul"></i>
                ÍNDICE
            </h2>
            <p>Navegue pelos tópicos do tutorial</p>
        </div>

        <div class="index-grid">
            <a href="#introducao" class="index-item">
                <span class="index-number">01</span>
                <span class="index-title">Introdução ao ProjetoBase</span>
            </a>
            <a href="#estrutura" class="index-item">
                <span class="index-number">02</span>
                <span class="index-title">Estrutura do Projeto</span>
            </a>
            <a href="#poo" class="index-item">
                <span class="index-number">03</span>
                <span class="index-title">O que é Programação Orientada a Objetos (POO)</span>
            </a>
            <a href="#pilares" class="index-item">
                <span class="index-number">04</span>
                <span class="index-title">Os 4 Pilares da POO</span>
            </a>
            <a href="#mvc" class="index-item">
                <span class="index-number">05</span>
                <span class="index-title">Entendendo o MVC</span>
            </a>
            <a href="#crud" class="index-item">
                <span class="index-number">06</span>
                <span class="index-title">Criando um CRUD Completo</span>
            </a>
            <a href="#configuracao" class="index-item">
                <span class="index-number">07</span>
                <span class="index-title">Configuração Inicial</span>
            </a>
            <a href="#menu" class="index-item">
                <span class="index-number">08</span>
                <span class="index-title">Gerenciando o Menu</span>
            </a>
            <a href="#modulos" class="index-item">
                <span class="index-number">09</span>
                <span class="index-title">Gerenciando Módulos</span>
            </a>
            <a href="#auth" class="index-item">
                <span class="index-number">10</span>
                <span class="index-title">Autenticação e Permissões</span>
            </a>
            <a href="#helpers" class="index-item">
                <span class="index-number">11</span>
                <span class="index-title">Helpers e Utilitários</span>
            </a>
            <a href="#novas-paginas" class="index-item">
                <span class="index-number">12</span>
                <span class="index-title">Criando Novas Páginas</span>
            </a>
            <a href="#glossario" class="index-item">
                <span class="index-number">13</span>
                <span class="index-title">Glossário de Termos</span>
            </a>
        </div>
    </div>
</section>

<!-- ============================================================ -->
<!-- SEÇÃO 3: INTRODUÇÃO                                         -->
<!-- ============================================================ -->
<section id="introducao" class="tutorial-section animate-in delay-2">
    <div class="container">
        <div class="section-header">
            <h2>
                <i class="fas fa-rocket" style="color: var(--color-impact-green);"></i>
                1. Introdução ao ProjetoBase
            </h2>
            <p>O que é o ProjetoBase e como ele funciona</p>
        </div>

        <div class="section-content">
            <div class="content-block">
                <h3>O que é o ProjetoBase?</h3>
                <p>
                    O <strong>ProjetoBase</strong> é um sistema PHP completo que já vem com 
                    toda a estrutura pronta para você começar a programar. Ele usa a 
                    arquitetura <strong>MVC</strong> (Model-View-Controller) e 
                    <strong>Programação Orientada a Objetos</strong> (POO).
                </p>
                <p>
                    <strong>Pense no ProjetoBase como uma casa já construída:</strong> 
                    você só precisa decorar os cômodos (adicionar suas funcionalidades) 
                    e pintar as paredes (personalizar o design).
                </p>
                
                <h4>Por que usar o ProjetoBase?</h4>
                <div class="table-wrapper">
                    <table class="feature-table">
                        <thead>
                            <tr>
                                <th>Motivo</th>
                                <th>Explicação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Economia de tempo</strong></td>
                                <td>Você não precisa criar toda a estrutura do zero</td>
                            </tr>
                            <tr>
                                <td><strong>Melhores práticas</strong></td>
                                <td>O código segue padrões de mercado (MVC, POO)</td>
                            </tr>
                            <tr>
                                <td><strong>Segurança</strong></td>
                                <td>Já tem proteção CSRF, validação de senha, sanitização</td>
                            </tr>
                            <tr>
                                <td><strong>Escalabilidade</strong></td>
                                <td>Fácil adicionar novos módulos e funcionalidades</td>
                            </tr>
                            <tr>
                                <td><strong>Documentação</strong></td>
                                <td>Código comentado e tutorial completo</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h3>O que ele já tem pronto?</h3>
                <div class="table-wrapper">
                    <table class="feature-table">
                        <thead>
                            <tr>
                                <th>Funcionalidade</th>
                                <th>Descrição</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Autenticação</strong></td>
                                <td>Login, cadastro, recuperação de senha</td>
                            </tr>
                            <tr>
                                <td><strong>CRUD de Usuários</strong></td>
                                <td>Criar, listar, editar e excluir usuários</td>
                            </tr>
                            <tr>
                                <td><strong>Perfis</strong></td>
                                <td>4 níveis: Master, Admin, Operador, Usuario</td>
                            </tr>
                            <tr>
                                <td><strong>Menu Dinâmico</strong></td>
                                <td>Configurável via arquivo PHP</td>
                            </tr>
                            <tr>
                                <td><strong>Módulos</strong></td>
                                <td>Ative/desative funcionalidades</td>
                            </tr>
                            <tr>
                                <td><strong>Notificações</strong></td>
                                <td>Sistema de notificações para usuários</td>
                            </tr>
                            <tr>
                                <td><strong>Logs</strong></td>
                                <td>Registro de atividades do sistema</td>
                            </tr>
                            <tr>
                                <td><strong>Backup</strong></td>
                                <td>Exportar banco de dados</td>
                            </tr>
                            <tr>
                                <td><strong>Relatórios</strong></td>
                                <td>PDF e Excel</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h4>Onde encontrar os recursos?</h4>
                <ul>
                    <li><strong>Configurações:</strong> <code>app/Config/</code></li>
                    <li><strong>Lógica do sistema:</strong> <code>app/Controllers/</code> e <code>app/Models/</code></li>
                    <li><strong>Interface:</strong> <code>app/Views/</code> e <code>public/css/</code></li>
                    <li><strong>Rotas:</strong> <code>routes/web.php</code></li>
                    <li><strong>Documentação:</strong> Esta página de tutorial</li>
                </ul>

                <h4>Como começar?</h4>
                <ol>
                    <li>Configure o arquivo <code>.env</code> com seus dados (banco, e-mail)</li>
                    <li>Execute o script <code>ProjetoBase_bd.sql</code> no MySQL</li>
                    <li>Acesse o sistema pelo navegador</li>
                    <li>Comece a personalizar!</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================ -->
<!-- SEÇÃO 4: ESTRUTURA DO PROJETO                              -->
<!-- ============================================================ -->
<section id="estrutura" class="tutorial-section animate-in delay-3">
    <div class="container">
        <div class="section-header">
            <h2>
                <i class="fas fa-folder-tree" style="color: #f59e0b;"></i>
                2. Estrutura do Projeto
            </h2>
            <p>Entenda a organização dos diretórios e arquivos</p>
        </div>

        <div class="section-content">
            <div class="content-block">
                <h3>Por que essa estrutura?</h3>
                <p>
                    O ProjetoBase segue o padrão <strong>MVC</strong> (Model-View-Controller), 
                    que separa a aplicação em três camadas:
                </p>
                <ul>
                    <li><strong>Model</strong> (Models): Dados e regras de negócio</li>
                    <li><strong>View</strong> (Views): Interface do usuário</li>
                    <li><strong>Controller</strong> (Controllers): Lógica da aplicação</li>
                </ul>
                <p>
                    Isso traz benefícios como <strong>organização</strong>, 
                    <strong>manutenibilidade</strong> e <strong>reutilização</strong> de código.
                </p>

                <h4>Onde trabalhar em cada situação?</h4>
                <div class="table-wrapper">
                    <table class="feature-table">
                        <thead>
                            <tr>
                                <th>O que você quer fazer</th>
                                <th>Onde mexer</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Adicionar uma página nova</td>
                                <td><code>app/Controllers/</code>, <code>app/Views/</code>, <code>routes/web.php</code></td>
                            </tr>
                            <tr>
                                <td>Modificar o menu</td>
                                <td><code>app/Config/menu.php</code></td>
                            </tr>
                            <tr>
                                <td>Configurar o sistema</td>
                                <td><code>.env</code> e <code>app/Config/</code></td>
                            </tr>
                            <tr>
                                <td>Criar uma nova tabela</td>
                                <td>Criar Model em <code>app/Models/</code></td>
                            </tr>
                            <tr>
                                <td>Mudar o estilo</td>
                                <td><code>public/css/</code></td>
                            </tr>
                            <tr>
                                <td>Adicionar JavaScript</td>
                                <td><code>public/js/</code></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h4>Exemplo prático de uso</h4>
                <p>
                    Se você quer criar uma página de "Clientes":
                </p>
                <ol>
                    <li>Cria <code>ClienteController.php</code> em <code>app/Controllers/</code></li>
                    <li>Cria a pasta <code>clientes/</code> em <code>app/Views/</code></li>
                    <li>Registra a rota em <code>routes/web.php</code></li>
                    <li>Adiciona ao menu em <code>app/Config/menu.php</code></li>
                </ol>

                <h4>Árvore completa do projeto</h4>
                <div class="tree-container">
                    <pre class="tree-structure">
ProjetoBase/
├── app/                         # Código fonte da aplicação
│   ├── Config/                  # Arquivos de configuração
│   │   ├── config.php           # Carrega as variáveis do .env
│   │   ├── database.php         # Conexão PDO com o banco de dados
│   │   ├── menu.php             # Menu dinâmico do sistema
│   │   └── modules.php          # Ativa/desativa módulos
│   │
│   ├── Controllers/             # Controladores - Lógica da aplicação
│   │   ├── AuthController.php   # Login, cadastro, recuperação de senha
│   │   ├── HomeController.php   # Página inicial do sistema
│   │   └── UsuarioController.php # Gerenciamento de usuários
│   │
│   ├── Core/                    # Núcleo do sistema (não mexer)
│   │   ├── App.php              # Configurações globais do sistema
│   │   ├── Router.php           # Sistema de roteamento
│   │   ├── Model.php            # Classe base para Models
│   │   └── CrudController.php   # CRUD genérico para qualquer tabela
│   │
│   ├── Helpers/                 # Funções auxiliares
│   │   ├── MenuHelper.php       # Renderiza o menu dinâmico
│   │   └── SecurityHelper.php   # Validação de senha, logs, sanitização
│   │
│   ├── Middleware/              # Filtros de requisição
│   │   ├── CsrfMiddleware.php   # Proteção contra ataques CSRF
│   │   └── AuthMiddleware.php   # Verifica se o usuário está logado
│   │
│   ├── Models/                  # Modelos - Interagem com o banco
│   │   └── Usuario.php          # Modelo de usuário
│   │
│   └── Views/                   # Templates - Interface do usuário
│       ├── layouts/             # Layouts base (header, footer, nav)
│       ├── auth/                # Páginas de autenticação
│       └── home/                # Páginas iniciais
│
├── public/                      # Arquivos públicos (acessíveis pelo navegador)
│   ├── css/                     # Arquivos CSS
│   ├── js/                      # Arquivos JavaScript
│   ├── uploads/                 # Arquivos enviados pelos usuários
│   └── index.php                # Ponto de entrada do sistema
│
├── routes/                      # Rotas da aplicação
│   └── web.php                  # Definição de todas as rotas
│
├── vendor/                      # Dependências do Composer (não mexer)
├── .env                         # Configurações de ambiente
├── composer.json                # Dependências do projeto
└── ProjetoBase_bd.sql           # Script do banco de dados
                    </pre>
                </div>

                <h4>Por que não mexer no Core/?</h4>
                <p>
                    As pastas <code>Core/</code> e <code>vendor/</code> contêm o 
                    <strong>coração do sistema</strong>. Mudar algo lá pode quebrar todo o 
                    projeto. Sempre que precisar estender uma funcionalidade, crie na pasta 
                    <code>Helpers/</code> ou estenda as classes através de herança.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================ -->
<!-- SEÇÃO 5: O QUE É POO                                        -->
<!-- ============================================================ -->
<section id="poo" class="tutorial-section animate-in delay-4">
    <div class="container">
        <div class="section-header">
            <h2>
                <i class="fas fa-cubes" style="color: #8b5cf6;"></i>
                3. O que é Programação Orientada a Objetos (POO)
            </h2>
            <p>Entenda os conceitos fundamentais da POO</p>
        </div>

        <div class="section-content">
            <div class="content-block">
                <h3>Analogia: Uma Fábrica de Carros</h3>
                <p>
                    Imagine uma <strong>fábrica de carros</strong>. Para produzir um carro, 
                    você não constrói cada peça do zero toda vez. Você tem um 
                    <strong>projeto</strong> (a "classe") que define como um carro deve ser: 
                    quantas rodas, qual motor, quais cores, etc. A partir desse projeto, 
                    você pode fabricar <strong>quantos carros quiser</strong> (os "objetos").
                </p>

                <h3>Os 4 conceitos fundamentais da POO</h3>
                
                <div class="concept-card">
                    <div class="concept-icon">
                        <i class="fas fa-cube"></i>
                    </div>
                    <div class="concept-content">
                        <h4>1. Classe - O Molde</h4>
                        <p>
                            A <strong>Classe</strong> é o "molde" que define como um objeto 
                            deve ser. Ela descreve as características (atributos) e 
                            comportamentos (métodos) que os objetos terão.
                        </p>
                        <p class="concept-example">
                            <strong>Analogia:</strong> Uma planta de uma casa. A planta 
                            não é a casa, mas define como a casa deve ser construída.
                        </p>
                    </div>
                </div>

                <div class="concept-card">
                    <div class="concept-icon">
                        <i class="fas fa-cube" style="color: #10b981;"></i>
                    </div>
                    <div class="concept-content">
                        <h4>2. Objeto - A Instância</h4>
                        <p>
                            Um <strong>Objeto</strong> é uma "cópia" ou "instância" da 
                            classe. É o que existe de verdade na memória do computador.
                        </p>
                        <p class="concept-example">
                            <strong>Analogia:</strong> A casa construída a partir da 
                            planta. Cada casa construída é um objeto diferente.
                        </p>
                    </div>
                </div>

                <div class="concept-card">
                    <div class="concept-icon">
                        <i class="fas fa-tag" style="color: #f59e0b;"></i>
                    </div>
                    <div class="concept-content">
                        <h4>3. Atributo - Características</h4>
                        <p>
                            Os <strong>Atributos</strong> são as características do objeto. 
                            São as variáveis que definem o estado do objeto.
                        </p>
                        <p class="concept-example">
                            <strong>Analogia:</strong> Cor do carro, modelo, ano, velocidade.
                        </p>
                    </div>
                </div>

                <div class="concept-card">
                    <div class="concept-icon">
                        <i class="fas fa-play" style="color: #ef4444;"></i>
                    </div>
                    <div class="concept-content">
                        <h4>4. Método - Ações</h4>
                        <p>
                            Os <strong>Métodos</strong> são as ações que o objeto pode 
                            realizar. São as funções que definem o comportamento do objeto.
                        </p>
                        <p class="concept-example">
                            <strong>Analogia:</strong> Acelerar, frear, ligar, desligar.
                        </p>
                    </div>
                </div>

                <h3>Exemplo completo em PHP</h3>
                <div class="code-block">
                    <pre><span class="code-comment">// ============================================================</span>
<span class="code-comment">// 1. DEFININDO UMA CLASSE (O MOLDE)</span>
<span class="code-comment">// ============================================================</span>
<span class="code-comment">// A palavra-chave "class" cria um novo tipo de dado</span>
<span class="code-comment">// O nome da classe sempre começa com letra maiúscula</span>
<span class="code-keyword">class</span> <span class="code-class">Carro</span>
{
    <span class="code-comment">// ============================================================</span>
    <span class="code-comment">// 2. ATRIBUTOS (CARACTERÍSTICAS)</span>
    <span class="code-comment">// ============================================================</span>
    <span class="code-keyword">public</span> <span class="code-variable">$cor</span>;        <span class="code-comment">// Cor do carro</span>
    <span class="code-keyword">public</span> <span class="code-variable">$marca</span>;      <span class="code-comment">// Marca do carro</span>
    <span class="code-keyword">public</span> <span class="code-variable">$velocidade</span> = <span class="code-number">0</span>; <span class="code-comment">// Velocidade atual (começa em 0)</span>

    <span class="code-comment">// ============================================================</span>
    <span class="code-comment">// 3. MÉTODOS (AÇÕES)</span>
    <span class="code-comment">// ============================================================</span>
    <span class="code-comment">// Métodos são funções que pertencem ao objeto</span>
    <span class="code-comment">// $this se refere ao próprio objeto</span>
    
    <span class="code-keyword">public function</span> <span class="code-method">acelerar</span>() {
        <span class="code-comment">// $this->velocidade acessa a velocidade DESTE carro</span>
        <span class="code-variable">$this</span>-><span class="code-variable">velocidade</span> += <span class="code-number">10</span>;
    }

    <span class="code-keyword">public function</span> <span class="code-method">mostrarInfo</span>() {
        <span class="code-function">echo</span> <span class="code-string">"Carro {$this->marca} na cor {$this->cor}"</span>;
    }
}

<span class="code-comment">// ============================================================</span>
<span class="code-comment">// 4. CRIANDO OBJETOS (INSTÂNCIAS DA CLASSE)</span>
<span class="code-comment">// ============================================================</span>
<span class="code-comment">// A palavra-chave "new" cria um novo objeto</span>
<span class="code-comment">// Cada objeto é independente e tem seus próprios dados</span>

<span class="code-variable">$carro1</span> = <span class="code-keyword">new</span> <span class="code-class">Carro</span>();
<span class="code-variable">$carro1</span>-><span class="code-variable">cor</span> = <span class="code-string">"Vermelho"</span>;
<span class="code-variable">$carro1</span>-><span class="code-variable">marca</span> = <span class="code-string">"Ferrari"</span>;
<span class="code-variable">$carro1</span>-><span class="code-method">acelerar</span>(); <span class="code-comment">// velocidade agora é 10</span>

<span class="code-variable">$carro2</span> = <span class="code-keyword">new</span> <span class="code-class">Carro</span>();
<span class="code-variable">$carro2</span>-><span class="code-variable">cor</span> = <span class="code-string">"Azul"</span>;
<span class="code-variable">$carro2</span>-><span class="code-variable">marca</span> = <span class="code-string">"Fusca"</span>;
<span class="code-comment">// $carro2->velocidade continua 0</span>

<span class="code-comment">// ============================================================</span>
<span class="code-comment">// 5. EXIBINDO AS INFORMAÇÕES</span>
<span class="code-comment">// ============================================================</span>
<span class="code-variable">$carro1</span>-><span class="code-method">mostrarInfo</span>(); <span class="code-comment">// "Carro Ferrari na cor Vermelho"</span>
<span class="code-variable">$carro2</span>-><span class="code-method">mostrarInfo</span>(); <span class="code-comment">// "Carro Fusca na cor Azul"</span></pre>
                </div>

                <h3>Vantagens da POO</h3>
                <div class="table-wrapper">
                    <table class="feature-table">
                        <thead>
                            <tr>
                                <th>Vantagem</th>
                                <th>Explicação</th>
                                <th>Exemplo Prático</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Organização</strong></td>
                                <td>Código mais organizado e fácil de entender</td>
                                <td>Classe Usuario tem tudo sobre usuários</td>
                            </tr>
                            <tr>
                                <td><strong>Reutilização</strong></td>
                                <td>Reutilize o mesmo "molde" várias vezes</td>
                                <td>Com a classe Carro, crie 100 carros diferentes</td>
                            </tr>
                            <tr>
                                <td><strong>Manutenção</strong></td>
                                <td>Mais fácil corrigir bugs e adicionar funcionalidades</td>
                                <td>Altere o método acelerar() uma vez</td>
                            </tr>
                            <tr>
                                <td><strong>Segurança</strong></td>
                                <td>Controle quem acessa cada parte do código</td>
                                <td>Atributos privados só acessados pela classe</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================ -->
<!-- SEÇÃO 6: OS 4 PILARES DA POO                               -->
<!-- ============================================================ -->
<section id="pilares" class="tutorial-section animate-in delay-5">
    <div class="container">
        <div class="section-header">
            <h2>
                <i class="fas fa-columns" style="color: #ec4899;"></i>
                4. Os 4 Pilares da POO
            </h2>
            <p>Os fundamentos que sustentam a Programação Orientada a Objetos</p>
        </div>

        <div class="section-content">
            <!-- PILAR 1: ENCAPSULAMENTO -->
            <div class="pilar-card">
                <div class="pilar-header">
                    <span class="pilar-number">01</span>
                    <h3>Encapsulamento</h3>
                </div>
                <div class="pilar-body">
                    <p>
                        <strong>Encapsulamento</strong> é o princípio que protege os dados 
                        internos de um objeto, permitindo que eles sejam acessados apenas 
                        através de <strong>métodos controlados</strong>. É como uma cápsula 
                        que protege o que está dentro.
                    </p>
                    <div class="pilar-analogy">
                        <strong>Analogia:</strong> Uma máquina de café. Você não precisa 
                        saber como ela funciona por dentro. Apenas coloca o pó, a água e 
                        aperta o botão. A máquina faz o trabalho internamente.
                    </div>
                    <div class="code-block mini">
                        <pre><span class="code-comment">// Atributo privado - ninguém pode acessar diretamente</span>
<span class="code-keyword">private</span> <span class="code-variable">$saldo</span> = <span class="code-number">0</span>;

<span class="code-comment">// Método público para depositar - com validação</span>
<span class="code-keyword">public function</span> <span class="code-method">depositar</span>(<span class="code-variable">$valor</span>) {
    <span class="code-keyword">if</span> (<span class="code-variable">$valor</span> > <span class="code-number">0</span>) {
        <span class="code-variable">$this</span>-><span class="code-variable">saldo</span> += <span class="code-variable">$valor</span>;
    }
}</pre>
                    </div>
                    <p>
                        <strong>Quando usar:</strong> Sempre que um dado não deve ser 
                        modificado diretamente de fora da classe.
                    </p>
                    <p>
                        <strong>Exemplo no ProjetoBase:</strong> A senha do usuário é 
                        armazenada como hash e nunca é exposta diretamente.
                    </p>
                </div>
            </div>

            <!-- PILAR 2: HERANÇA -->
            <div class="pilar-card">
                <div class="pilar-header">
                    <span class="pilar-number">02</span>
                    <h3>Herança</h3>
                </div>
                <div class="pilar-body">
                    <p>
                        <strong>Herança</strong> é um mecanismo que permite criar uma nova 
                        classe baseada em uma classe existente. A nova classe 
                        (<strong>subclasse</strong>) herda todos os atributos e métodos da 
                        classe original.
                    </p>
                    <div class="pilar-analogy">
                        <strong>Analogia:</strong> Você herda características dos seus pais: 
                        cor dos olhos, tipo de cabelo, etc. Mas você também tem 
                        características únicas.
                    </div>
                    <div class="code-block mini">
                        <pre><span class="code-comment">// Classe mãe (superclasse)</span>
<span class="code-keyword">class</span> <span class="code-class">Animal</span> {
    <span class="code-keyword">public</span> <span class="code-variable">$nome</span>;
    <span class="code-keyword">public function</span> <span class="code-method">comer</span>() {
        <span class="code-function">echo</span> <span class="code-string">"{$this->nome} está comendo."</span>;
    }
}

<span class="code-comment">// Classe filha (subclasse) - herda tudo de Animal</span>
<span class="code-keyword">class</span> <span class="code-class">Cachorro</span> <span class="code-keyword">extends</span> <span class="code-class">Animal</span> {
    <span class="code-keyword">public</span> <span class="code-variable">$raca</span>; <span class="code-comment">// Atributo exclusivo</span>
    
    <span class="code-keyword">public function</span> <span class="code-method">latir</span>() { <span class="code-comment">// Método exclusivo</span>
        <span class="code-function">echo</span> <span class="code-string">"{$this->nome} está latindo: Au Au!"</span>;
    }
}</pre>
                    </div>
                    <p>
                        <strong>Quando usar:</strong> Quando uma classe é uma "especialização" 
                        de outra. Ex: Usuario, Aluno, Professor herdam de Pessoa.
                    </p>
                    <p>
                        <strong>Exemplo no ProjetoBase:</strong> O <code>CrudController</code> 
                        é estendido por <code>ExemploController</code>, que herda todos os 
                        métodos CRUD.
                    </p>
                </div>
            </div>

            <!-- PILAR 3: POLIMORFISMO -->
            <div class="pilar-card">
                <div class="pilar-header">
                    <span class="pilar-number">03</span>
                    <h3>Polimorfismo</h3>
                </div>
                <div class="pilar-body">
                    <p>
                        <strong>Polimorfismo</strong> (do grego "muitas formas") é a 
                        capacidade de um mesmo nome de método ter 
                        <strong>comportamentos diferentes</strong> em classes diferentes.
                    </p>
                    <div class="pilar-analogy">
                        <strong>Analogia:</strong> Todo controle remoto tem um botão 
                        "ligar". Mas o comportamento é diferente para cada aparelho: 
                        na TV acende a tela, no ar condicionado começa a refrigerar.
                    </div>
                    <div class="code-block mini">
                        <pre><span class="code-comment">// Interface define o contrato</span>
<span class="code-keyword">interface</span> <span class="code-class">FormaGeometrica</span> {
    <span class="code-keyword">public function</span> <span class="code-method">calcularArea</span>();
}

<span class="code-comment">// Cada classe implementa de forma diferente</span>
<span class="code-keyword">class</span> <span class="code-class">Circulo</span> <span class="code-keyword">implements</span> <span class="code-class">FormaGeometrica</span> {
    <span class="code-keyword">public function</span> <span class="code-method">calcularArea</span>() {
        <span class="code-keyword">return</span> <span class="code-number">3.14</span> * <span class="code-variable">$this</span>-><span class="code-variable">raio</span> * <span class="code-variable">$this</span>-><span class="code-variable">raio</span>;
    }
}

<span class="code-keyword">class</span> <span class="code-class">Retangulo</span> <span class="code-keyword">implements</span> <span class="code-class">FormaGeometrica</span> {
    <span class="code-keyword">public function</span> <span class="code-method">calcularArea</span>() {
        <span class="code-keyword">return</span> <span class="code-variable">$this</span>-><span class="code-variable">largura</span> * <span class="code-variable">$this</span>-><span class="code-variable">altura</span>;
    }
}</pre>
                    </div>
                    <p>
                        <strong>Quando usar:</strong> Quando diferentes objetos precisam 
                        responder ao mesmo método de maneiras diferentes.
                    </p>
                    <p>
                        <strong>Exemplo no ProjetoBase:</strong> Diferentes controllers 
                        podem ter o método <code>index()</code>, mas cada um exibe dados 
                        diferentes.
                    </p>
                </div>
            </div>

            <!-- PILAR 4: ABSTRAÇÃO -->
            <div class="pilar-card">
                <div class="pilar-header">
                    <span class="pilar-number">04</span>
                    <h3>Abstração</h3>
                </div>
                <div class="pilar-body">
                    <p>
                        <strong>Abstração</strong> é o princípio de 
                        <strong>esconder detalhes complexos</strong> e mostrar apenas o 
                        que é essencial para quem usa o objeto. É focar no "o que" e 
                        não no "como".
                    </p>
                    <div class="pilar-analogy">
                        <strong>Analogia:</strong> Um celular. Você não precisa saber 
                        como o processador funciona para fazer uma ligação. Apenas digita 
                        o número e aperta o botão verde.
                    </div>
                    <div class="code-block mini">
                        <pre><span class="code-comment">// Classe abstrata - não pode ser instanciada diretamente</span>
<span class="code-keyword">abstract class</span> <span class="code-class">Funcionario</span> {
    <span class="code-comment">// Método abstrato - obrigatório para classes filhas</span>
    <span class="code-keyword">abstract public function</span> <span class="code-method">calcularSalario</span>();
    
    <span class="code-comment">// Método concreto - já implementado</span>
    <span class="code-keyword">public function</span> <span class="code-method">exibirInfo</span>() {
        <span class="code-function">echo</span> <span class="code-string">"Funcionário: {$this->nome}"</span>;
        <span class="code-function">echo</span> <span class="code-string">"Salário: R$ " . $this->calcularSalario()</span>;
    }
}</pre>
                    </div>
                    <p>
                        <strong>Quando usar:</strong> Para definir um "contrato" que as 
                        classes filhas devem seguir, sem implementar todos os detalhes.
                    </p>
                    <p>
                        <strong>Exemplo no ProjetoBase:</strong> O <code>CrudController</code> 
                        é abstrato e define métodos que os controllers específicos devem 
                        implementar.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================ -->
<!-- SEÇÃO 7: ENTENDENDO O MVC                                  -->
<!-- ============================================================ -->
<section id="mvc" class="tutorial-section animate-in delay-6">
    <div class="container">
        <div class="section-header">
            <h2>
                <i class="fas fa-sitemap" style="color: #3b82f6;"></i>
                5. Entendendo o MVC
            </h2>
            <p>Model-View-Controller: a arquitetura do ProjetoBase</p>
        </div>

        <div class="section-content">
            <div class="content-block">
                <h3>O que é MVC?</h3>
                <p>
                    MVC (Model-View-Controller) é um padrão de arquitetura que separa 
                    a aplicação em três camadas:
                </p>

                <div class="mvc-diagram">
                    <div class="mvc-layer mvc-model">
                        <div class="mvc-icon">
                            <i class="fas fa-database"></i>
                        </div>
                        <h4>MODEL</h4>
                        <p>Dados e Regras de Negócio</p>
                        <p class="mvc-detail">Interage com o Banco de Dados</p>
                    </div>
                    <div class="mvc-arrow">⬇</div>
                    <div class="mvc-layer mvc-view">
                        <div class="mvc-icon">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <h4>VIEW</h4>
                        <p>Interface do Usuário</p>
                        <p class="mvc-detail">HTML / CSS / JS</p>
                    </div>
                    <div class="mvc-arrow">⬇</div>
                    <div class="mvc-layer mvc-controller">
                        <div class="mvc-icon">
                            <i class="fas fa-code"></i>
                        </div>
                        <h4>CONTROLLER</h4>
                        <p>Lógica da Aplicação</p>
                        <p class="mvc-detail">Recebe requisições, processa dados</p>
                    </div>
                </div>

                <h4>1. Model (Modelo)</h4>
                <p>
                    O <strong>Model</strong> é responsável por <strong>gerenciar os dados</strong> 
                    e as <strong>regras de negócio</strong>. Ele se comunica diretamente com 
                    o banco de dados.
                </p>
                <ul>
                    <li><strong>O que faz:</strong> Busca, insere, atualiza e deleta registros</li>
                    <li><strong>Onde fica:</strong> <code>app/Models/</code></li>
                    <li><strong>Exemplo:</strong> A classe <code>Usuario</code> que busca usuários no banco</li>
                </ul>

                <h4>2. View (Visão)</h4>
                <p>
                    A <strong>View</strong> é responsável por <strong>exibir os dados</strong> 
                    para o usuário. É a interface que o usuário vê e interage.
                </p>
                <ul>
                    <li><strong>O que faz:</strong> Exibe dados, contém HTML/CSS/JS</li>
                    <li><strong>Onde fica:</strong> <code>app/Views/</code></li>
                    <li><strong>Exemplo:</strong> <code>usuarios/index.php</code> que lista os usuários</li>
                </ul>

                <h4>3. Controller (Controlador)</h4>
                <p>
                    O <strong>Controller</strong> é o <strong>intermediário</strong> entre 
                    o Model e a View. Ele recebe as requisições do usuário, processa os dados 
                    e decide qual View será exibida.
                </p>
                <ul>
                    <li><strong>O que faz:</strong> Recebe requisições, chama Models, prepara dados para View</li>
                    <li><strong>Onde fica:</strong> <code>app/Controllers/</code></li>
                    <li><strong>Exemplo:</strong> A classe <code>UsuarioController</code></li>
                </ul>

                <h3>Fluxo de Requisição - Passo a Passo</h3>
                <div class="flow-steps">
                    <div class="flow-step">
                        <span class="step-number">1</span>
                        <span class="step-text">Usuário acessa a URL: /usuarios</span>
                    </div>
                    <div class="flow-arrow">↓</div>
                    <div class="flow-step">
                        <span class="step-number">2</span>
                        <span class="step-text">O Router analisa a URL e encontra a rota</span>
                    </div>
                    <div class="flow-arrow">↓</div>
                    <div class="flow-step">
                        <span class="step-number">3</span>
                        <span class="step-text">Router direciona para: UsuarioController@index</span>
                    </div>
                    <div class="flow-arrow">↓</div>
                    <div class="flow-step">
                        <span class="step-number">4</span>
                        <span class="step-text">Controller recebe a requisição e chama o Model</span>
                    </div>
                    <div class="flow-arrow">↓</div>
                    <div class="flow-step">
                        <span class="step-number">5</span>
                        <span class="step-text">Model consulta o banco e retorna os dados</span>
                    </div>
                    <div class="flow-arrow">↓</div>
                    <div class="flow-step">
                        <span class="step-number">6</span>
                        <span class="step-text">Controller recebe os dados e envia para a View</span>
                    </div>
                    <div class="flow-arrow">↓</div>
                    <div class="flow-step">
                        <span class="step-number">7</span>
                        <span class="step-text">View renderiza o HTML e exibe para o usuário</span>
                    </div>
                </div>

                <h4>Por que usar MVC?</h4>
                <ul>
                    <li><strong>Organização:</strong> Cada parte do código tem seu lugar</li>
                    <li><strong>Manutenção:</strong> Fácil encontrar e corrigir problemas</li>
                    <li><strong>Reutilização:</strong> Models e Helpers podem ser reutilizados</li>
                    <li><strong>Colaboração:</strong> Vários desenvolvedores podem trabalhar em partes diferentes</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================ -->
<!-- SEÇÃO 8: CRIANDO UM CRUD COMPLETO                          -->
<!-- ============================================================ -->
<section id="crud" class="tutorial-section animate-in delay-7">
    <div class="container">
        <div class="section-header">
            <h2>
                <i class="fas fa-table" style="color: #10b981;"></i>
                6. Criando um CRUD Completo
            </h2>
            <p>Aprenda a criar um CRUD usando o sistema genérico</p>
        </div>

        <div class="section-content">
            <div class="content-block">
                <h3>O que é CRUD?</h3>
                <p>
                    <strong>CRUD</strong> = 
                    <strong>C</strong>reate (Criar), 
                    <strong>R</strong>ead (Ler), 
                    <strong>U</strong>pdate (Atualizar), 
                    <strong>D</strong>elete (Deletar)
                </p>
                <p>
                    <strong>Por que usar o CRUD genérico?</strong> O ProjetoBase tem uma 
                    classe <code>CrudController</code> que já implementa todas as operações 
                    básicas. Você só precisa configurar alguns parâmetros e já tem um CRUD 
                    completo funcionando.
                </p>

                <h3>Passo 1: Criar a Tabela no Banco</h3>
                <div class="code-block mini">
                    <pre><span class="code-comment">-- ============================================================</span>
<span class="code-comment">-- TABELA PRODUTO</span>
<span class="code-comment">-- ============================================================</span>
<span class="code-keyword">CREATE TABLE IF NOT EXISTS</span> produto (
    <span class="code-variable">id_produto</span> <span class="code-keyword">INT PRIMARY KEY AUTO_INCREMENT</span>,
    <span class="code-variable">nome</span> <span class="code-keyword">VARCHAR(150) NOT NULL</span>,
    <span class="code-variable">descricao</span> <span class="code-keyword">TEXT</span>,
    <span class="code-variable">preco</span> <span class="code-keyword">DECIMAL(10, 2) NOT NULL</span>,
    <span class="code-variable">quantidade</span> <span class="code-keyword">INT DEFAULT 0</span>,
    <span class="code-variable">status</span> <span class="code-keyword">ENUM('ativo', 'inativo') DEFAULT 'ativo'</span>,
    <span class="code-variable">data_criacao</span> <span class="code-keyword">TIMESTAMP DEFAULT CURRENT_TIMESTAMP</span>
);</pre>
                </div>

                <h3>Passo 2: Criar o Controller</h3>
                <p>
                    O Controller é onde você configura como o CRUD vai funcionar. 
                    Você define a tabela, os campos, quem pode acessar, etc.
                </p>
                <div class="code-block">
                    <pre><span class="code-comment">// ============================================================</span>
<span class="code-comment">// ARQUIVO: app/Controllers/ProdutoController.php</span>
<span class="code-comment">// ============================================================</span>

<span class="code-keyword">require_once</span> <span class="code-string">__DIR__ . '/../Core/CrudController.php'</span>;

<span class="code-keyword">class</span> <span class="code-class">ProdutoController</span> <span class="code-keyword">extends</span> <span class="code-class">CrudController</span>
{
    <span class="code-keyword">public function</span> <span class="code-method">__construct</span>()
    {
        <span class="code-comment">// Tabela que será gerenciada</span>
        <span class="code-variable">$this</span>-><span class="code-variable">table</span> = <span class="code-string">'produto'</span>;
        
        <span class="code-comment">// Chave primária da tabela</span>
        <span class="code-variable">$this</span>-><span class="code-variable">primaryKey</span> = <span class="code-string">'id_produto'</span>;

        <span class="code-comment">// Campos que aparecem no formulário e na lista</span>
        <span class="code-variable">$this</span>-><span class="code-variable">fields</span> = [
            <span class="code-string">'nome'</span>,        <span class="code-comment">// Nome do produto</span>
            <span class="code-string">'descricao'</span>,   <span class="code-comment">// Descrição</span>
            <span class="code-string">'preco'</span>,       <span class="code-comment">// Preço</span>
            <span class="code-string">'quantidade'</span>,  <span class="code-comment">// Quantidade em estoque</span>
            <span class="code-string">'status'</span>       <span class="code-comment">// Status (ativo/inativo)</span>
        ];

        <span class="code-comment">// Campos obrigatórios</span>
        <span class="code-variable">$this</span>-><span class="code-variable">requiredFields</span> = [
            <span class="code-string">'nome'</span>,   <span class="code-comment">// Nome é obrigatório</span>
            <span class="code-string">'preco'</span>   <span class="code-comment">// Preço é obrigatório</span>
        ];

        <span class="code-comment">// Perfis que podem acessar (1=Master, 2=Admin)</span>
        <span class="code-variable">$this</span>-><span class="code-variable">allowedRoles</span> = [1, 2];

        <span class="code-comment">// Nomes para exibição</span>
        <span class="code-variable">$this</span>-><span class="code-variable">labelSingular</span> = <span class="code-string">'Produto'</span>;
        <span class="code-variable">$this</span>-><span class="code-variable">labelPlural</span> = <span class="code-string">'Produtos'</span>;

        <span class="code-comment">// Itens por página</span>
        <span class="code-variable">$this</span>-><span class="code-variable">perPage</span> = <span class="code-number">20</span>;

        <span class="code-comment">// Ordenação padrão</span>
        <span class="code-variable">$this</span>-><span class="code-variable">defaultSort</span> = <span class="code-string">'nome'</span>;
        <span class="code-variable">$this</span>-><span class="code-variable">defaultOrder</span> = <span class="code-string">'ASC'</span>;

        <span class="code-keyword">parent</span>::<span class="code-method">__construct</span>();
    }
}</pre>
                </div>

                <h3>Passo 3: Registrar as Rotas</h3>
                <p>
                    As rotas mapeiam as URLs para os métodos do Controller. Você pode 
                    usar o método automático ou registrar manualmente.
                </p>
                <div class="code-block mini">
                    <pre><span class="code-comment">// ============================================================</span>
<span class="code-comment">// ARQUIVO: routes/web.php</span>
<span class="code-comment">// ============================================================</span>

<span class="code-comment">// Método automático (recomendado)</span>
<span class="code-keyword">require_once</span> <span class="code-string">__DIR__ . '/../app/Core/DynamicCrudHelper.php'</span>;
<span class="code-class">DynamicCrudHelper</span>::<span class="code-method">registerRoutes</span>(
    <span class="code-variable">$router</span>, 
    <span class="code-string">'produto'</span>, 
    <span class="code-string">'ProdutoController'</span>, 
    [1, 2]
);

<span class="code-comment">// OU registre manualmente:</span>
<span class="code-comment">/*</span>
<span class="code-comment">$router->get('/produtos', 'ProdutoController@index', [1, 2]);</span>
<span class="code-comment">$router->get('/produtos/criar', 'ProdutoController@criar', [1, 2]);</span>
<span class="code-comment">$router->post('/produtos/salvar', 'ProdutoController@salvar', [1, 2]);</span>
<span class="code-comment">$router->get('/produtos/editar', 'ProdutoController@editar', [1, 2]);</span>
<span class="code-comment">$router->post('/produtos/atualizar', 'ProdutoController@atualizar', [1, 2]);</span>
<span class="code-comment">$router->get('/produtos/excluir', 'ProdutoController@excluir', [1, 2]);</span>
<span class="code-comment">*/</span></pre>
                </div>

                <h4>Rotas que serão criadas automaticamente:</h4>
                <ul>
                    <li><code>/produtos</code> - Lista todos os produtos</li>
                    <li><code>/produtos/criar</code> - Formulário de criação</li>
                    <li><code>/produtos/salvar</code> - Salva um novo produto</li>
                    <li><code>/produtos/editar</code> - Formulário de edição</li>
                    <li><code>/produtos/atualizar</code> - Atualiza um produto</li>
                    <li><code>/produtos/excluir</code> - Exclui um produto</li>
                </ul>

                <h4>Personalizando o CRUD</h4>
                <p>
                    Você pode sobrescrever métodos no Controller para adicionar 
                    validações customizadas ou lógica adicional:
                </p>
                <div class="code-block mini">
                    <pre><span class="code-comment">// Adicionar validação customizada</span>
<span class="code-keyword">protected function</span> <span class="code-method">validateData</span>(<span class="code-variable">$dados</span>, <span class="code-variable">$id</span> = <span class="code-keyword">null</span>)
{
    <span class="code-keyword">parent</span>::<span class="code-method">validateData</span>(<span class="code-variable">$dados</span>, <span class="code-variable">$id</span>);
    
    <span class="code-comment">// Validação customizada</span>
    <span class="code-keyword">if</span> (<span class="code-keyword">isset</span>(<span class="code-variable">$dados</span>[<span class="code-string">'preco'</span>]) && <span class="code-variable">$dados</span>[<span class="code-string">'preco'</span>] < <span class="code-number">0</span>) {
        <span class="code-variable">$_SESSION</span>[<span class="code-string">'flash'</span>] = [
            <span class="code-string">'tipo'</span> => <span class="code-string">'erro'</span>,
            <span class="code-string">'mensagem'</span> => <span class="code-string">'O preço não pode ser negativo.'</span>
        ];
        <span class="code-keyword">exit</span>;
    }
}</pre>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================ -->
<!-- SEÇÃO 9: CONFIGURAÇÃO INICIAL                              -->
<!-- ============================================================ -->
<section id="configuracao" class="tutorial-section animate-in delay-8">
    <div class="container">
        <div class="section-header">
            <h2>
                <i class="fas fa-cog" style="color: #6b7280;"></i>
                7. Configuração Inicial
            </h2>
            <p>Configure o projeto para começar a desenvolver</p>
        </div>

        <div class="section-content">
            <div class="content-block">
                <h3>Por que configurar o .env?</h3>
                <p>
                    O arquivo <code>.env</code> contém todas as configurações do sistema 
                    que podem mudar de ambiente para ambiente (desenvolvimento, produção, etc). 
                    Ele nunca deve ser versionado no Git (por isso está no <code>.gitignore</code>).
                </p>

                <h3>Passo 1: Configurar o .env</h3>
                <div class="code-block mini">
                    <pre><span class="code-comment"># ============================================================</span>
<span class="code-comment"># ARQUIVO: .env</span>
<span class="code-comment"># ============================================================</span>

<span class="code-comment"># Nome do projeto (aparece no título e menu)</span>
<span class="code-keyword">APP_NAME</span>=MeuProjeto

<span class="code-comment"># URL completa do projeto</span>
<span class="code-keyword">APP_URL</span>=http://localhost/MeuProjeto

<span class="code-comment"># Caminho base do projeto (subpasta)</span>
<span class="code-keyword">APP_BASE_PATH</span>=/MeuProjeto

<span class="code-comment"># ============================================================</span>
<span class="code-comment"># CONFIGURAÇÕES DE BANCO DE DADOS</span>
<span class="code-comment"># ============================================================</span>

<span class="code-keyword">DB_HOST</span>=127.0.0.1
<span class="code-keyword">DB_PORT</span>=3306
<span class="code-keyword">DB_NAME</span>=meu_projeto
<span class="code-keyword">DB_USER</span>=root
<span class="code-keyword">DB_PASS</span>=

<span class="code-comment"># ============================================================</span>
<span class="code-comment"># CONFIGURAÇÕES DE E-MAIL</span>
<span class="code-comment"># ============================================================</span>

<span class="code-keyword">MAIL_HOST</span>=smtp.gmail.com
<span class="code-keyword">MAIL_PORT</span>=587
<span class="code-keyword">MAIL_USER</span>=seuemail@gmail.com
<span class="code-keyword">MAIL_PASS</span>=suasenha
<span class="code-keyword">MAIL_FROM_NAME</span>=MeuProjeto</pre>
                </div>

                <h4>O que cada variável faz?</h4>
                <ul>
                    <li><strong>APP_NAME:</strong> Nome do sistema que aparece no título e menu</li>
                    <li><strong>APP_URL:</strong> URL completa do sistema</li>
                    <li><strong>APP_BASE_PATH:</strong> Caminho base (se estiver em subpasta)</li>
                    <li><strong>DB_*:</strong> Configurações de conexão com o banco de dados</li>
                    <li><strong>MAIL_*:</strong> Configurações para envio de e-mails</li>
                </ul>

                <h4>Onde o .env é usado?</h4>
                <ul>
                    <li><code>app/Core/App.php</code> - Carrega as configurações</li>
                    <li><code>app/Config/database.php</code> - Usa para conectar ao banco</li>
                    <li><code>app/Core/Mail.php</code> - Usa para enviar e-mails</li>
                    <li>Em qualquer lugar com <code>App::get('CHAVE')</code></li>
                </ul>

                <h3>Passo 2: Criar o Banco de Dados</h3>
                <div class="code-block mini">
                    <pre><span class="code-comment">-- ============================================================</span>
<span class="code-comment">-- CRIA O BANCO DE DADOS</span>
<span class="code-comment">-- ============================================================</span>
<span class="code-keyword">CREATE DATABASE</span> meu_projeto;
<span class="code-keyword">USE</span> meu_projeto;

<span class="code-comment">-- ============================================================</span>
<span class="code-comment">-- EXECUTA O SCRIPT DO PROJETOBASE</span>
<span class="code-comment">-- ============================================================</span>
<span class="code-keyword">SOURCE</span> ProjetoBase_bd.sql;</pre>
                </div>

                <h4>O que o script do banco faz?</h4>
                <ul>
                    <li>Cria as tabelas: <code>usuario</code>, <code>perfil</code>, <code>log_sistema</code>, etc</li>
                    <li>Insere os perfis padrão: Master, Admin, Operador, Usuario</li>
                    <li>Cria usuários de teste com senha '123'</li>
                </ul>

                <h3>Passo 3: Ativar/Desativar Módulos</h3>
                <div class="code-block mini">
                    <pre><span class="code-comment">// ============================================================</span>
<span class="code-comment">// ARQUIVO: app/Config/modules.php</span>
<span class="code-comment">// ============================================================</span>

<span class="code-keyword">return</span> [
    <span class="code-string">'modules'</span> => [
        <span class="code-string">'logs'</span> => <span class="code-keyword">true</span>,          <span class="code-comment">// Ativa logs do sistema</span>
        <span class="code-string">'notificacoes'</span> => <span class="code-keyword">true</span>,  <span class="code-comment">// Ativa notificações</span>
        <span class="code-string">'backup'</span> => <span class="code-keyword">true</span>,        <span class="code-comment">// Ativa backup</span>
        <span class="code-string">'api'</span> => <span class="code-keyword">false</span>,          <span class="code-comment">// Desativa API</span>
        <span class="code-string">'export'</span> => <span class="code-keyword">true</span>,       <span class="code-comment">// Ativa exportação</span>
        <span class="code-string">'uploads'</span> => <span class="code-keyword">true</span>,      <span class="code-comment">// Ativa upload</span>
    ],
];</pre>
                </div>

                <h4>Como verificar se um módulo está ativo?</h4>
                <div class="code-block mini">
                    <pre><span class="code-keyword">if</span> (<span class="code-class">MenuHelper</span>::<span class="code-method">isModuleEnabled</span>(<span class="code-string">'logs'</span>)) {
    <span class="code-comment">// Mostra o link para logs</span>
    <span class="code-function">echo</span> <span class="code-string">'&lt;a href="/logs"&gt;Logs&lt;/a&gt;'</span>;
}</pre>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================ -->
<!-- SEÇÃO 10: GERENCIANDO O MENU                              -->
<!-- ============================================================ -->
<section id="menu" class="tutorial-section animate-in delay-9">
    <div class="container">
        <div class="section-header">
            <h2>
                <i class="fas fa-bars" style="color: #8b5cf6;"></i>
                8. Gerenciando o Menu
            </h2>
            <p>Configure o menu dinâmico do sistema</p>
        </div>

        <div class="section-content">
            <div class="content-block">
                <h3>Por que o menu é dinâmico?</h3>
                <p>
                    O menu do ProjetoBase é <strong>dinâmico</strong> porque é gerado a 
                    partir de um arquivo de configuração (<code>app/Config/menu.php</code>). 
                    Isso permite que você:
                </p>
                <ul>
                    <li>Adicione ou remova itens sem mexer no HTML</li>
                    <li>Controle quem vê cada item (por perfil)</li>
                    <li>Ative/desative itens baseado em módulos</li>
                    <li>Crie submenus facilmente</li>
                </ul>

                <h3>Estrutura do Menu</h3>
                <div class="code-block">
                    <pre><span class="code-comment">// ============================================================</span>
<span class="code-comment">// ARQUIVO: app/Config/menu.php</span>
<span class="code-comment">// ============================================================</span>

<span class="code-keyword">return</span> [
    <span class="code-string">'menu'</span> => [
        <span class="code-comment">// ============================================================</span>
        <span class="code-comment">// ITEM SIMPLES</span>
        <span class="code-comment">// ============================================================</span>
        [
            <span class="code-string">'label'</span> => <span class="code-string">'Início'</span>,           <span class="code-comment">// Texto que aparece</span>
            <span class="code-string">'icon'</span> => <span class="code-string">'fas fa-home'</span>,       <span class="code-comment">// Ícone Font Awesome</span>
            <span class="code-string">'url'</span> => <span class="code-string">'/'</span>,                  <span class="code-comment">// URL do item</span>
            <span class="code-string">'roles'</span> => [1, 2, 3, 4],       <span class="code-comment">// Quem pode ver (todos)</span>
        ],
        
        <span class="code-comment">// ============================================================</span>
        <span class="code-comment">// ITEM COM SUBMENU</span>
        <span class="code-comment">// ============================================================</span>
        [
            <span class="code-string">'label'</span> => <span class="code-string">'Administração'</span>,    <span class="code-comment">// Menu principal</span>
            <span class="code-string">'icon'</span> => <span class="code-string">'fas fa-cog'</span>,        <span class="code-comment">// Ícone do menu</span>
            <span class="code-string">'roles'</span> => [1, 2],             <span class="code-comment">// Admin e Master veem</span>
            <span class="code-string">'subitems'</span> => [                <span class="code-comment">// Subitens</span>
                [
                    <span class="code-string">'label'</span> => <span class="code-string">'Usuários'</span>,
                    <span class="code-string">'icon'</span> => <span class="code-string">'fas fa-users'</span>,
                    <span class="code-string">'url'</span> => <span class="code-string">'/usuarios'</span>,
                    <span class="code-string">'roles'</span> => [1, 2],
                ],
            ],
        ],
        
        <span class="code-comment">// ============================================================</span>
        <span class="code-comment">// ITEM COM MÓDULO</span>
        <span class="code-comment">// ============================================================</span>
        [
            <span class="code-string">'label'</span> => <span class="code-string">'Logs'</span>,
            <span class="code-string">'icon'</span> => <span class="code-string">'fas fa-history'</span>,
            <span class="code-string">'url'</span> => <span class="code-string">'/logs'</span>,
            <span class="code-string">'roles'</span> => [1],
            <span class="code-string">'module'</span> => <span class="code-string">'logs'</span>, <span class="code-comment">// Só aparece se módulo ativo</span>
        ],
    ],
];</pre>
                </div>

                <h4>Campos do menu - Explicação completa</h4>
                <div class="table-wrapper">
                    <table class="feature-table">
                        <thead>
                            <tr>
                                <th>Campo</th>
                                <th>Obrigatório?</th>
                                <th>O que faz</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>label</code></td>
                                <td>Sim</td>
                                <td>Texto que aparece no menu</td>
                            </tr>
                            <tr>
                                <td><code>icon</code></td>
                                <td>Não</td>
                                <td>Ícone Font Awesome (ex: fas fa-home)</td>
                            </tr>
                            <tr>
                                <td><code>url</code></td>
                                <td>Sim (se não tiver subitems)</td>
                                <td>URL para onde o item leva</td>
                            </tr>
                            <tr>
                                <td><code>roles</code></td>
                                <td>Sim</td>
                                <td>Array com IDs dos perfis que podem ver</td>
                            </tr>
                            <tr>
                                <td><code>subitems</code></td>
                                <td>Não</td>
                                <td>Array com itens do submenu</td>
                            </tr>
                            <tr>
                                <td><code>module</code></td>
                                <td>Não</td>
                                <td>Nome do módulo que deve estar ativo</td>
                            </tr>
                            <tr>
                                <td><code>badge</code></td>
                                <td>Não</td>
                                <td>Mostra um badge (ex: notificacoes)</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h4>Como encontrar ícones?</h4>
                <p>
                    Os ícones são do <strong>Font Awesome</strong>. Para encontrar ícones:
                </p>
                <ol>
                    <li>Acesse <a href="https://fontawesome.com/icons" target="_blank">fontawesome.com/icons</a></li>
                    <li>Procure o ícone que você quer</li>
                    <li>Copie o nome (ex: <code>fa-user</code>)</li>
                    <li>Use com <code>fas</code> ou <code>far</code>: <code>fas fa-user</code></li>
                </ol>

                <h4>Exemplos de aplicação</h4>
                <ul>
                    <li><strong>Menu para admin apenas:</strong> <code>'roles' => [1, 2]</code></li>
                    <li><strong>Menu para todos logados:</strong> <code>'roles' => [1, 2, 3, 4]</code></li>
                    <li><strong>Menu público:</strong> <code>'roles' => []</code> (vazio = todos)</li>
                    <li><strong>Submenu com itens diferentes por perfil:</strong> Cada subitem pode ter <code>roles</code> diferentes</li>
                </ul>

                <h4>Como o menu é renderizado?</h4>
                <p>
                    O arquivo <code>app/Helpers/MenuHelper.php</code> lê o array e gera 
                    o HTML do menu. Ele:
                </p>
                <ol>
                    <li>Verifica se o usuário tem permissão (roles)</li>
                    <li>Verifica se o módulo está ativo (module)</li>
                    <li>Gera os submenus se existirem</li>
                    <li>Adiciona badges se configurado</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================ -->
<!-- SEÇÃO 11: GERENCIANDO MÓDULOS                             -->
<!-- ============================================================ -->
<section id="modulos" class="tutorial-section animate-in delay-10">
    <div class="container">
        <div class="section-header">
            <h2>
                <i class="fas fa-puzzle-piece" style="color: #f59e0b;"></i>
                9. Gerenciando Módulos
            </h2>
            <p>Ative ou desative funcionalidades do sistema</p>
        </div>

        <div class="section-content">
            <div class="content-block">
                <h3>Por que usar módulos?</h3>
                <p>
                    Os módulos permitem <strong>ativar ou desativar funcionalidades</strong> 
                    do sistema sem precisar remover código. Isso é útil para:
                </p>
                <ul>
                    <li>Desativar funcionalidades não utilizadas</li>
                    <li>Ativar funcionalidades gradualmente</li>
                    <li>Personalizar o sistema para diferentes clientes</li>
                    <li>Testar novas funcionalidades em produção</li>
                </ul>

                <h3>Ativando/Desativando Módulos</h3>
                <div class="code-block mini">
                    <pre><span class="code-comment">// ============================================================</span>
<span class="code-comment">// ARQUIVO: app/Config/modules.php</span>
<span class="code-comment">// ============================================================</span>

<span class="code-keyword">return</span> [
    <span class="code-string">'modules'</span> => [
        <span class="code-comment">// true = ativado, false = desativado</span>
        <span class="code-string">'logs'</span> => <span class="code-keyword">true</span>,        <span class="code-comment">// Logs do sistema</span>
        <span class="code-string">'backup'</span> => <span class="code-keyword">true</span>,      <span class="code-comment">// Backup do banco</span>
        <span class="code-string">'api'</span> => <span class="code-keyword">false</span>,         <span class="code-comment">// API REST</span>
        <span class="code-string">'export'</span> => <span class="code-keyword">true</span>,       <span class="code-comment">// Exportar relatórios</span>
        <span class="code-string">'uploads'</span> => <span class="code-keyword">true</span>,     <span class="code-comment">// Upload de arquivos</span>
        <span class="code-string">'auditoria'</span> => <span class="code-keyword">true</span>,   <span class="code-comment">// Log de auditoria</span>
    ],
    <span class="code-comment">// Módulos personalizados</span>
    <span class="code-string">'custom_modules'</span> => [
        <span class="code-string">'clientes'</span> => <span class="code-keyword">true</span>,
        <span class="code-string">'vendas'</span> => <span class="code-keyword">false</span>,
    ],
];</pre>
                </div>

                <h4>Onde os módulos são usados?</h4>
                <ul>
                    <li><strong>Nas rotas:</strong> Só registra se o módulo estiver ativo</li>
                    <li><strong>No menu:</strong> Só mostra se o módulo estiver ativo</li>
                    <li><strong>Nos controllers:</strong> Verifica antes de executar ações</li>
                    <li><strong>Nas views:</strong> Mostra/esconde elementos baseado no módulo</li>
                </ul>

                <h3>Verificando se um Módulo está Ativo</h3>
                <div class="code-block mini">
                    <pre><span class="code-comment">// Em qualquer lugar do código</span>
<span class="code-keyword">if</span> (<span class="code-class">MenuHelper</span>::<span class="code-method">isModuleEnabled</span>(<span class="code-string">'logs'</span>)) {
    <span class="code-comment">// Mostra o link para a página de logs</span>
    <span class="code-function">echo</span> <span class="code-string">'&lt;a href="/logs"&gt;Logs&lt;/a&gt;'</span>;
}</pre>
                </div>

                <h3>Rotas Condicionais</h3>
                <div class="code-block mini">
                    <pre><span class="code-comment">// ============================================================</span>
<span class="code-comment">// ARQUIVO: routes/web.php</span>
<span class="code-comment">// ============================================================</span>

<span class="code-comment">// Carrega a configuração de módulos</span>
<span class="code-variable">$modules</span> = <span class="code-keyword">require</span> <span class="code-string">__DIR__ . '/../app/Config/modules.php'</span>;
<span class="code-variable">$modulos</span> = <span class="code-variable">$modules</span>[<span class="code-string">'modules'</span>] ?? [];

<span class="code-comment">// Só registra a rota se o módulo estiver ativo</span>
<span class="code-keyword">if</span> (<span class="code-variable">$modulos</span>[<span class="code-string">'logs'</span>] ?? <span class="code-keyword">false</span>) {
    <span class="code-variable">$router</span>-><span class="code-method">get</span>(<span class="code-string">'/logs'</span>, <span class="code-string">'LogController@index'</span>, [1]);
}

<span class="code-keyword">if</span> (<span class="code-variable">$modulos</span>[<span class="code-string">'backup'</span>] ?? <span class="code-keyword">false</span>) {
    <span class="code-variable">$router</span>-><span class="code-method">get</span>(<span class="code-string">'/master/backup'</span>, <span class="code-string">'MasterController@backup'</span>, [1]);
}</pre>
                </div>

                <h3>Criando um Módulo Personalizado</h3>
                <p>
                    Para criar seu próprio módulo, siga estes passos:
                </p>
                <ol>
                    <li><strong>Adicione ao modules.php:</strong> <code>'meu_modulo' => true</code></li>
                    <li><strong>Verifique no código:</strong> <code>MenuHelper::isModuleEnabled('meu_modulo')</code></li>
                    <li><strong>Use nas rotas:</strong> Condicional para registrar as rotas</li>
                    <li><strong>No menu:</strong> Adicione <code>'module' => 'meu_modulo'</code></li>
                </ol>

                <h4>Exemplo completo de módulo personalizado</h4>
                <div class="code-block mini">
                    <pre><span class="code-comment">// 1. Configurar no modules.php</span>
<span class="code-string">'custom_modules'</span> => [
    <span class="code-string">'blog'</span> => <span class="code-keyword">true</span>,
],

<span class="code-comment">// 2. Verificar no código</span>
<span class="code-keyword">if</span> (<span class="code-class">MenuHelper</span>::<span class="code-method">isModuleEnabled</span>(<span class="code-string">'blog'</span>)) {
    <span class="code-comment">// Mostra o blog</span>
}

<span class="code-comment">// 3. Adicionar ao menu</span>
[
    <span class="code-string">'label'</span> => <span class="code-string">'Blog'</span>,
    <span class="code-string">'icon'</span> => <span class="code-string">'fas fa-blog'</span>,
    <span class="code-string">'url'</span> => <span class="code-string">'/blog'</span>,
    <span class="code-string">'roles'</span> => [1, 2, 3, 4],
    <span class="code-string">'module'</span> => <span class="code-string">'blog'</span>, <span class="code-comment">// Só aparece se módulo ativo</span>
]</pre>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================ -->
<!-- SEÇÃO 12: AUTENTICAÇÃO E PERMISSÕES                       -->
<!-- ============================================================ -->
<section id="auth" class="tutorial-section animate-in delay-11">
    <div class="container">
        <div class="section-header">
            <h2>
                <i class="fas fa-lock" style="color: #ef4444;"></i>
                10. Autenticação e Permissões
            </h2>
            <p>Entenda o sistema de login e controle de acesso</p>
        </div>

        <div class="section-content">
            <div class="content-block">
                <h3>Como funciona a autenticação?</h3>
                <p>
                    O ProjetoBase usa <strong>sessões PHP</strong> para gerenciar a 
                    autenticação. Quando o usuário faz login:
                </p>
                <ol>
                    <li>O sistema verifica as credenciais no banco</li>
                    <li>Se válidas, cria uma sessão com os dados do usuário</li>
                    <li>O <code>$_SESSION['usuario']</code> contém ID, nome, email e role</li>
                    <li>Middlewares verificam se a sessão existe</li>
                </ol>

                <h3>Sistema de Perfis</h3>
                <p>
                    Os perfis são definidos no banco de dados e determinam o que cada 
                    usuário pode fazer no sistema.
                </p>
                <div class="code-block mini">
                    <pre><span class="code-comment">-- ============================================================</span>
<span class="code-comment">-- TABELA PERFIL</span>
<span class="code-comment">-- ============================================================</span>
<span class="code-keyword">CREATE TABLE</span> perfil (
    <span class="code-variable">id_perfil</span> <span class="code-keyword">INT PRIMARY KEY AUTO_INCREMENT</span>,
    <span class="code-variable">perfil</span> <span class="code-keyword">VARCHAR(20) UNIQUE NOT NULL</span>
);

<span class="code-comment">-- PERFIS PADRÃO</span>
<span class="code-keyword">INSERT INTO</span> perfil <span class="code-keyword">VALUES</span>
(1, <span class="code-string">'Master'</span>),    <span class="code-comment">-- Acesso total</span>
(2, <span class="code-string">'Admin'</span>),     <span class="code-comment">-- Gerencia usuários</span>
(3, <span class="code-string">'Operador'</span>),  <span class="code-comment">-- Operações básicas</span>
(4, <span class="code-string">'Usuario'</span>);   <span class="code-comment">-- Acesso restrito</span></pre>
                </div>

                <h4>O que cada perfil pode fazer?</h4>
                <div class="table-wrapper">
                    <table class="feature-table">
                        <thead>
                            <tr>
                                <th>Perfil</th>
                                <th>ID</th>
                                <th>Permissões</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Master</strong></td>
                                <td>1</td>
                                <td>Acesso total: ver logs, backup, configurações, tudo</td>
                            </tr>
                            <tr>
                                <td><strong>Admin</strong></td>
                                <td>2</td>
                                <td>Gerencia usuários, relatórios, conteúdos</td>
                            </tr>
                            <tr>
                                <td><strong>Operador</strong></td>
                                <td>3</td>
                                <td>Operações básicas, visualização de dados</td>
                            </tr>
                            <tr>
                                <td><strong>Usuario</strong></td>
                                <td>4</td>
                                <td>Apenas própria conta e informações públicas</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h3>Verificando Permissões</h3>
                
                <h4>1. Nas Rotas</h4>
                <div class="code-block mini">
                    <pre><span class="code-comment">// ============================================================</span>
<span class="code-comment">// ARQUIVO: routes/web.php</span>
<span class="code-comment">// ============================================================</span>

<span class="code-comment">// Apenas Master e Admin podem acessar</span>
<span class="code-variable">$router</span>-><span class="code-method">get</span>(<span class="code-string">'/usuarios'</span>, <span class="code-string">'UsuarioController@index'</span>, [1, 2]);

<span class="code-comment">// Apenas Master pode acessar</span>
<span class="code-variable">$router</span>-><span class="code-method">get</span>(<span class="code-string">'/logs'</span>, <span class="code-string">'LogController@index'</span>, [1]);

<span class="code-comment">// Qualquer usuário logado pode acessar</span>
<span class="code-variable">$router</span>-><span class="code-method">get</span>(<span class="code-string">'/user'</span>, <span class="code-string">'UserController@index'</span>, [1, 2, 3, 4]);

<span class="code-comment">// Público (qualquer um, logado ou não)</span>
<span class="code-variable">$router</span>-><span class="code-method">get</span>(<span class="code-string">'/sobre'</span>, <span class="code-string">'SobreController@index'</span>);</pre>
                </div>

                <h4>2. Nos Controllers</h4>
                <div class="code-block mini">
                    <pre><span class="code-keyword">public function</span> <span class="code-method">index</span>()
{
    <span class="code-comment">// 1. VERIFICA SE ESTÁ LOGADO</span>
    <span class="code-keyword">if</span> (!<span class="code-keyword">isset</span>(<span class="code-variable">$_SESSION</span>[<span class="code-string">'usuario'</span>])) {
        <span class="code-method">header</span>(<span class="code-string">'Location: ' . App::getBasePath() . '/login'</span>);
        <span class="code-keyword">exit</span>;
    }

    <span class="code-comment">// 2. VERIFICA O PERFIL</span>
    <span class="code-variable">$role</span> = (<span class="code-keyword">int</span>) <span class="code-variable">$_SESSION</span>[<span class="code-string">'usuario'</span>][<span class="code-string">'role'</span>];
    
    <span class="code-comment">// Verifica se é Master ou Admin</span>
    <span class="code-keyword">if</span> (!<span class="code-keyword">in_array</span>(<span class="code-variable">$role</span>, [1, 2])) {
        <span class="code-method">http_response_code</span>(403);
        <span class="code-function">echo</span> <span class="code-string">"&lt;h1&gt;403 - Acesso Negado&lt;/h1&gt;"</span>;
        <span class="code-keyword">exit</span>;
    }
}</pre>
                </div>

                <h4>3. Nas Views</h4>
                <div class="code-block mini">
                    <pre><span class="code-variable">$role</span> = <span class="code-variable">$_SESSION</span>[<span class="code-string">'usuario'</span>][<span class="code-string">'role'</span>] ?? <span class="code-number">0</span>;
?>

<span class="code-comment">&lt;!-- Conteúdo visível para todos --&gt;</span>
&lt;p&gt;Bem-vindo ao sistema!&lt;/p&gt;

<span class="code-comment">&lt;!-- Conteúdo visível apenas para Master --&gt;</span>
&lt;?php <span class="code-keyword">if</span> (<span class="code-variable">$role</span> == <span class="code-number">1</span>): ?&gt;
    &lt;div class=<span class="code-string">"master-only"</span>&gt;
        &lt;h3&gt;Área Master&lt;/h3&gt;
        &lt;a href=<span class="code-string">"/logs"</span>&gt;Ver Logs&lt;/a&gt;
    &lt;/div&gt;
&lt;?php <span class="code-keyword">endif</span>; ?&gt;

<span class="code-comment">&lt;!-- Conteúdo visível para Master e Admin --&gt;</span>
&lt;?php <span class="code-keyword">if</span> (<span class="code-keyword">in_array</span>(<span class="code-variable">$role</span>, [1, 2])): ?&gt;
    &lt;div class=<span class="code-string">"admin-only"</span>&gt;
        &lt;a href=<span class="code-string">"/usuarios"</span>&gt;Gerenciar Usuários&lt;/a&gt;
    &lt;/div&gt;
&lt;?php <span class="code-keyword">endif</span>; ?&gt;</pre>
                </div>

                <h4>Boa prática: Criar um Helper para verificar permissões</h4>
                <div class="code-block mini">
                    <pre><span class="code-comment">// Em app/Helpers/AuthHelper.php</span>
<span class="code-keyword">class</span> <span class="code-class">AuthHelper</span>
{
    <span class="code-keyword">public static function</span> <span class="code-method">hasRole</span>(<span class="code-variable">$roles</span>)
    {
        <span class="code-keyword">if</span> (!<span class="code-keyword">isset</span>(<span class="code-variable">$_SESSION</span>[<span class="code-string">'usuario'</span>])) {
            <span class="code-keyword">return</span> <span class="code-keyword">false</span>;
        }
        <span class="code-variable">$role</span> = (<span class="code-keyword">int</span>) <span class="code-variable">$_SESSION</span>[<span class="code-string">'usuario'</span>][<span class="code-string">'role'</span>];
        <span class="code-keyword">return</span> <span class="code-keyword">in_array</span>(<span class="code-variable">$role</span>, <span class="code-variable">$roles</span>);
    }
}

<span class="code-comment">// Uso:</span>
<span class="code-keyword">if</span> (<span class="code-class">AuthHelper</span>::<span class="code-method">hasRole</span>([1, 2])) {
    <span class="code-comment">// Mostra conteúdo para Master e Admin</span>
}</pre>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================ -->
<!-- SEÇÃO 13: HELPERS E UTILITÁRIOS                           -->
<!-- ============================================================ -->
<section id="helpers" class="tutorial-section animate-in delay-12">
    <div class="container">
        <div class="section-header">
            <h2>
                <i class="fas fa-toolbox" style="color: #f59e0b;"></i>
                11. Helpers e Utilitários
            </h2>
            <p>Funções auxiliares para facilitar o desenvolvimento</p>
        </div>

        <div class="section-content">
            <div class="content-block">
                <h3>O que são Helpers?</h3>
                <p>
                    Helpers são <strong>classes com funções reutilizáveis</strong> que 
                    executam tarefas comuns no sistema. Eles ajudam a:
                </p>
                <ul>
                    <li>Evitar repetição de código (DRY)</li>
                    <li>Manter a lógica organizada</li>
                    <li>Facilitar manutenções futuras</li>
                    <li>Centralizar funcionalidades</li>
                </ul>

                <h3>Lista de Helpers Disponíveis</h3>
                <div class="table-wrapper">
                    <table class="feature-table">
                        <thead>
                            <tr>
                                <th>Helper</th>
                                <th>Função</th>
                                <th>Arquivo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>MenuHelper</strong></td>
                                <td>Renderiza o menu dinâmico</td>
                                <td><code>app/Helpers/MenuHelper.php</code></td>
                            </tr>
                            <tr>
                                <td><strong>SecurityHelper</strong></td>
                                <td>Valida senha, sanitiza arquivos, logs</td>
                                <td><code>app/Helpers/SecurityHelper.php</code></td>
                            </tr>
                            <tr>
                                <td><strong>UploadHelper</strong></td>
                                <td>Upload de arquivos com segurança</td>
                                <td><code>app/Helpers/UploadHelper.php</code></td>
                            </tr>
                            <tr>
                                <td><strong>PaginationHelper</strong></td>
                                <td>Paginação de resultados</td>
                                <td><code>app/Helpers/PaginationHelper.php</code></td>
                            </tr>
                            <tr>
                                <td><strong>ViewHelper</strong></td>
                                <td>CSRF field, formatação de data/moeda</td>
                                <td><code>app/Helpers/ViewHelper.php</code></td>
                            </tr>
                            <tr>
                                <td><strong>ExcelHelper</strong></td>
                                <td>Exportar para Excel</td>
                                <td><code>app/Helpers/ExcelHelper.php</code></td>
                            </tr>
                            <tr>
                                <td><strong>PdfHelper</strong></td>
                                <td>Exportar para PDF</td>
                                <td><code>app/Helpers/PdfHelper.php</code></td>
                            </tr>
                            <tr>
                                <td><strong>NavHelper</strong></td>
                                <td>Informações do usuário na navegação</td>
                                <td><code>app/Helpers/NavHelper.php</code></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h3>Como Usar os Helpers</h3>

                <h4>SecurityHelper - Validar Senha</h4>
                <p>
                    O <code>SecurityHelper</code> valida se uma senha é forte o suficiente:
                </p>
                <ul>
                    <li>Mínimo 8 caracteres</li>
                    <li>Pelo menos 1 letra maiúscula</li>
                    <li>Pelo menos 1 letra minúscula</li>
                    <li>Pelo menos 1 número</li>
                    <li>Pelo menos 1 caractere especial</li>
                </ul>
                <div class="code-block mini">
                    <pre><span class="code-variable">$senha</span> = <span class="code-variable">$_POST</span>[<span class="code-string">'senha'</span>] ?? <span class="code-string">''</span>;
<span class="code-variable">$resultado</span> = <span class="code-class">SecurityHelper</span>::<span class="code-method">validarForcaSenha</span>(<span class="code-variable">$senha</span>);

<span class="code-keyword">if</span> (<span class="code-variable">$resultado</span>[<span class="code-string">'valida'</span>]) {
    <span class="code-comment">// Senha forte - pode salvar</span>
} <span class="code-keyword">else</span> {
    <span class="code-comment">// Senha fraca - mostra os erros</span>
    <span class="code-function">echo</span> <span class="code-string">"Senha fraca. Requisitos: " . implode(', ', $resultado['erros'])</span>;
}</pre>
                </div>

                <h4>PaginationHelper - Paginação</h4>
                <p>
                    O <code>PaginationHelper</code> calcula os dados da paginação e gera 
                    os links de navegação automaticamente.
                </p>
                <div class="code-block mini">
                    <pre><span class="code-comment">// No Controller:</span>
<span class="code-variable">$total</span> = <span class="code-variable">$model</span>-><span class="code-method">getTotal</span>();
<span class="code-variable">$pagina</span> = (<span class="code-keyword">int</span>) (<span class="code-variable">$_GET</span>[<span class="code-string">'pagina'</span>] ?? <span class="code-number">1</span>);
<span class="code-variable">$limite</span> = <span class="code-number">20</span>;

<span class="code-variable">$paginacao</span> = <span class="code-class">PaginationHelper</span>::<span class="code-method">paginate</span>(<span class="code-variable">$total</span>, <span class="code-variable">$pagina</span>, <span class="code-variable">$limite</span>);
<span class="code-variable">$registros</span> = <span class="code-variable">$model</span>-><span class="code-method">getWithPagination</span>(<span class="code-variable">$limite</span>, <span class="code-variable">$paginacao</span>[<span class="code-string">'offset'</span>]);

<span class="code-variable">$paginationHtml</span> = <span class="code-class">PaginationHelper</span>::<span class="code-method">render</span>(
    <span class="code-class">App</span>::<span class="code-method">getBasePath</span>() . <span class="code-string">'/clientes'</span>,
    <span class="code-variable">$pagina</span>,
    <span class="code-variable">$paginacao</span>[<span class="code-string">'totalPaginas'</span>]
);</pre>
                </div>

                <h4>ViewHelper - CSRF e Formatação</h4>
                <p>
                    O <code>ViewHelper</code> fornece funções úteis para usar nas views:
                </p>
                <ul>
                    <li><strong>csrfField():</strong> Campo de proteção CSRF para formulários</li>
                    <li><strong>escape():</strong> Escapa HTML para prevenir XSS</li>
                    <li><strong>formatDate():</strong> Formata data para exibição</li>
                    <li><strong>formatMoney():</strong> Formata valor monetário</li>
                    <li><strong>statusBadge():</strong> Gera badge de status</li>
                </ul>
                <div class="code-block mini">
                    <pre><span class="code-comment">// CSRF Field (sempre usar em formulários POST)</span>
&lt;form method=<span class="code-string">"POST"</span>&gt;
    &lt;?= <span class="code-class">ViewHelper</span>::<span class="code-method">csrfField</span>() ?&gt;
    <span class="code-comment">&lt;!-- ... --&gt;</span>
&lt;/form&gt;

<span class="code-comment">// Escapar HTML (evita XSS)</span>
&lt;p&gt;&lt;?= <span class="code-class">ViewHelper</span>::<span class="code-method">escape</span>(<span class="code-variable">$usuario</span>[<span class="code-string">'nome'</span>]) ?&gt;&lt;/p&gt;

<span class="code-comment">// Formatar data</span>
&lt;p&gt;&lt;?= <span class="code-class">ViewHelper</span>::<span class="code-method">formatDate</span>(<span class="code-variable">$usuario</span>[<span class="code-string">'data_criacao'</span>]) ?&gt;&lt;/p&gt;
<span class="code-comment">// Saída: 02/08/2026 10:30</span>

<span class="code-comment">// Formatar dinheiro</span>
&lt;p&gt;&lt;?= <span class="code-class">ViewHelper</span>::<span class="code-method">formatMoney</span>(<span class="code-number">29.90</span>) ?&gt;&lt;/p&gt;
<span class="code-comment">// Saída: R$ 29,90</span></pre>
                </div>

                <h4>ExcelHelper - Exportar para Excel</h4>
                <p>
                    O <code>ExcelHelper</code> gera arquivos Excel (.xls) a partir de 
                    arrays de dados.
                </p>
                <div class="code-block mini">
                    <pre><span class="code-comment">// No Controller:</span>
<span class="code-variable">$usuarios</span> = <span class="code-variable">$model</span>-><span class="code-method">getAll</span>();
<span class="code-variable">$dados</span> = <span class="code-class">ExcelHelper</span>::<span class="code-method">prepararDados</span>(<span class="code-variable">$usuarios</span>);
<span class="code-class">ExcelHelper</span>::<span class="code-method">gerar</span>(<span class="code-variable">$dados</span>, <span class="code-string">'relatorio.xls'</span>, <span class="code-string">'Relatório'</span>);</pre>
                </div>

                <h4>Criando seu próprio Helper</h4>
                <div class="code-block mini">
                    <pre><span class="code-comment">// app/Helpers/MeuHelper.php</span>
<span class="code-keyword">class</span> <span class="code-class">MeuHelper</span>
{
    <span class="code-keyword">public static function</span> <span class="code-method">minhaFuncao</span>(<span class="code-variable">$parametro</span>)
    {
        <span class="code-comment">// Sua lógica aqui</span>
        <span class="code-keyword">return</span> <span class="code-variable">$resultado</span>;
    }
}

<span class="code-comment">// Uso em qualquer lugar:</span>
<span class="code-variable">$resultado</span> = <span class="code-class">MeuHelper</span>::<span class="code-method">minhaFuncao</span>(<span class="code-variable">$valor</span>);</pre>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================ -->
<!-- SEÇÃO 14: CRIANDO NOVAS PÁGINAS                           -->
<!-- ============================================================ -->
<section id="novas-paginas" class="tutorial-section animate-in delay-13">
    <div class="container">
        <div class="section-header">
            <h2>
                <i class="fas fa-file-plus" style="color: #10b981;"></i>
                12. Criando Novas Páginas
            </h2>
            <p>Passo a passo para criar páginas no sistema</p>
        </div>

        <div class="section-content">
            <div class="content-block">
                <h3>Por que seguir este padrão?</h3>
                <p>
                    O ProjetoBase segue o padrão MVC, que separa a lógica (Controller), 
                    os dados (Model) e a interface (View). Isso torna o código mais 
                    organizado e fácil de manter.
                </p>

                <h3>Passo 1: Criar a Rota</h3>
                <p>
                    A rota mapeia uma URL para um Controller específico.
                </p>
                <div class="code-block mini">
                    <pre><span class="code-comment">// ============================================================</span>
<span class="code-comment">// ARQUIVO: routes/web.php</span>
<span class="code-comment">// ============================================================</span>

<span class="code-comment">// Cria uma rota GET para a página</span>
<span class="code-variable">$router</span>-><span class="code-method">get</span>(<span class="code-string">'/minha-pagina'</span>, <span class="code-string">'MinhaPaginaController@index'</span>);

<span class="code-comment">// Com permissões (apenas Master e Admin)</span>
<span class="code-variable">$router</span>-><span class="code-method">get</span>(<span class="code-string">'/minha-pagina'</span>, <span class="code-string">'MinhaPaginaController@index'</span>, [1, 2]);</pre>
                </div>

                <h3>Passo 2: Criar o Controller</h3>
                <p>
                    O Controller contém a lógica da página. Ele prepara os dados e 
                    carrega a View.
                </p>
                <div class="code-block mini">
                    <pre><span class="code-comment">// ============================================================</span>
<span class="code-comment">// ARQUIVO: app/Controllers/MinhaPaginaController.php</span>
<span class="code-comment">// ============================================================</span>

<span class="code-keyword">require_once</span> <span class="code-string">__DIR__ . '/../Core/App.php'</span>;

<span class="code-keyword">class</span> <span class="code-class">MinhaPaginaController</span>
{
    <span class="code-keyword">public function</span> <span class="code-method">index</span>()
    {
        <span class="code-comment">// Dados para a view</span>
        <span class="code-variable">$dados</span> = [
            <span class="code-string">'titulo'</span> => <span class="code-string">'Minha Página'</span>,
            <span class="code-string">'conteudo'</span> => <span class="code-string">'Este é o conteúdo da minha página.'</span>
        ];
        
        <span class="code-comment">// Carrega a View</span>
        <span class="code-keyword">require_once</span> <span class="code-string">__DIR__ . '/../Views/minha_pagina/index.php'</span>;
    }
}</pre>
                </div>

                <h3>Passo 3: Criar a View</h3>
                <p>
                    A View contém o HTML e a apresentação dos dados.
                </p>
                <div class="code-block mini">
                    <pre><span class="code-comment">&lt;?php</span>
<span class="code-comment">// ============================================================</span>
<span class="code-comment">// ARQUIVO: app/Views/minha_pagina/index.php</span>
<span class="code-comment">// ============================================================</span>

<span class="code-variable">$tituloPagina</span> = <span class="code-string">'Minha Página - ' . App::getName()</span>;
<span class="code-variable">$cssPagina</span> = <span class="code-string">'home.css'</span>;
<span class="code-keyword">require_once</span> <span class="code-string">__DIR__ . '/../layouts/header.php'</span>;
<span class="code-keyword">require_once</span> <span class="code-string">__DIR__ . '/../layouts/nav.php'</span>;

<span class="code-variable">$basePath</span> = <span class="code-class">App</span>::<span class="code-method">getBasePath</span>();
?&gt;

&lt;section class=<span class="code-string">"section-block animate-in"</span>&gt;
    &lt;div class=<span class="code-string">"container"</span>&gt;
        &lt;h1&gt;Minha Página&lt;/h1&gt;
        &lt;p&gt;&lt;?= <span class="code-variable">$conteudo</span> ?? <span class="code-string">'Conteúdo padrão'</span> ?&gt;&lt;/p&gt;
        
        &lt;div style=<span class="code-string">"margin-top: 2rem;"</span>&gt;
            &lt;a href=<span class="code-string">"&lt;?= $basePath ?&gt;/"</span> class=<span class="code-string">"btn btn-primary"</span>&gt;
                &lt;i class=<span class="code-string">"fas fa-arrow-left"</span>&gt;&lt;/i&gt; Voltar
            &lt;/a&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/section&gt;

&lt;?php <span class="code-keyword">require_once</span> <span class="code-string">__DIR__ . '/../layouts/footer.php'</span>; ?&gt;</pre>
                </div>

                <h3>Passo 4: Adicionar ao Menu (opcional)</h3>
                <p>
                    Para adicionar a página ao menu, edite <code>app/Config/menu.php</code>:
                </p>
                <div class="code-block mini">
                    <pre><span class="code-comment">// ============================================================</span>
<span class="code-comment">// ARQUIVO: app/Config/menu.php</span>
<span class="code-comment">// ============================================================</span>

[
    <span class="code-string">'label'</span> => <span class="code-string">'Minha Página'</span>,
    <span class="code-string">'icon'</span> => <span class="code-string">'fas fa-file'</span>,
    <span class="code-string">'url'</span> => <span class="code-string">'/minha-pagina'</span>,
    <span class="code-string">'roles'</span> => [1, 2, 3, 4], <span class="code-comment">// Quem pode ver</span>
],</pre>
                </div>

                <h4>Página com dados do banco</h4>
                <div class="code-block mini">
                    <pre><span class="code-comment">// No Controller:</span>
<span class="code-keyword">public function</span> <span class="code-method">index</span>()
{
    <span class="code-comment">// Busca dados do banco</span>
    <span class="code-variable">$model</span> = <span class="code-keyword">new</span> <span class="code-class">MeuModel</span>();
    <span class="code-variable">$dados</span> = <span class="code-variable">$model</span>-><span class="code-method">getAll</span>();
    
    <span class="code-keyword">require_once</span> <span class="code-string">__DIR__ . '/../Views/minha_pagina/index.php'</span>;
}

<span class="code-comment">// Na View:</span>
&lt;?php <span class="code-keyword">foreach</span> (<span class="code-variable">$dados</span> <span class="code-keyword">as</span> <span class="code-variable">$item</span>): ?&gt;
    &lt;div&gt;&lt;?= <span class="code-variable">$item</span>[<span class="code-string">'nome'</span>] ?&gt;&lt;/div&gt;
&lt;?php <span class="code-keyword">endforeach</span>; ?&gt;</pre>
                </div>

                <h4>Página com formulário (POST)</h4>
                <div class="code-block mini">
                    <pre><span class="code-comment">// Rotas:</span>
<span class="code-variable">$router</span>-><span class="code-method">get</span>(<span class="code-string">'/contato'</span>, <span class="code-string">'ContatoController@index'</span>);
<span class="code-variable">$router</span>-><span class="code-method">post</span>(<span class="code-string">'/contato/enviar'</span>, <span class="code-string">'ContatoController@enviar'</span>);

<span class="code-comment">// Controller:</span>
<span class="code-keyword">public function</span> <span class="code-method">enviar</span>()
{
    <span class="code-comment">// Processa o formulário</span>
    <span class="code-variable">$nome</span> = <span class="code-variable">$_POST</span>[<span class="code-string">'nome'</span>] ?? <span class="code-string">''</span>;
    <span class="code-comment">// ...</span>
}</pre>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================ -->
<!-- SEÇÃO 15: GLOSSÁRIO DE TERMOS                             -->
<!-- ============================================================ -->
<section id="glossario" class="tutorial-section animate-in delay-14">
    <div class="container">
        <div class="section-header">
            <h2>
                <i class="fas fa-book" style="color: #8b5cf6;"></i>
                13. Glossário de Termos
            </h2>
            <p>Referência rápida de todos os termos importantes</p>
        </div>

        <div class="section-content">
            <div class="content-block">
                <h3>Termos da POO</h3>
                <div class="table-wrapper">
                    <table class="feature-table">
                        <thead>
                            <tr>
                                <th>Termo</th>
                                <th>Significado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Classe</strong></td>
                                <td>Molde que define como um objeto deve ser</td>
                            </tr>
                            <tr>
                                <td><strong>Objeto</strong></td>
                                <td>Instância da classe. O que existe na memória</td>
                            </tr>
                            <tr>
                                <td><strong>Atributo</strong></td>
                                <td>Características do objeto (variáveis)</td>
                            </tr>
                            <tr>
                                <td><strong>Método</strong></td>
                                <td>Ações que o objeto pode realizar (funções)</td>
                            </tr>
                            <tr>
                                <td><strong>Encapsulamento</strong></td>
                                <td>Proteger dados internos do objeto</td>
                            </tr>
                            <tr>
                                <td><strong>Herança</strong></td>
                                <td>Criar classe baseada em outra existente</td>
                            </tr>
                            <tr>
                                <td><strong>Polimorfismo</strong></td>
                                <td>Mesmo método com comportamentos diferentes</td>
                            </tr>
                            <tr>
                                <td><strong>Abstração</strong></td>
                                <td>Esconder detalhes complexos</td>
                            </tr>
                            <tr>
                                <td><strong>Construtor</strong></td>
                                <td>Método executado ao criar o objeto (__construct)</td>
                            </tr>
                            <tr>
                                <td><strong>Interface</strong></td>
                                <td>Contrato que define métodos obrigatórios</td>
                            </tr>
                            <tr>
                                <td><strong>Classe Abstrata</strong></td>
                                <td>Classe que não pode ser instanciada</td>
                            </tr>
                            <tr>
                                <td><strong>$this</strong></td>
                                <td>Referência ao próprio objeto dentro da classe</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h3>Termos do MVC</h3>
                <div class="table-wrapper">
                    <table class="feature-table">
                        <thead>
                            <tr>
                                <th>Termo</th>
                                <th>Significado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Model</strong></td>
                                <td>Dados e regras de negócio</td>
                            </tr>
                            <tr>
                                <td><strong>View</strong></td>
                                <td>Interface do usuário (HTML/CSS/JS)</td>
                            </tr>
                            <tr>
                                <td><strong>Controller</strong></td>
                                <td>Lógica da aplicação</td>
                            </tr>
                            <tr>
                                <td><strong>Router</strong></td>
                                <td>Sistema que direciona as requisições</td>
                            </tr>
                            <tr>
                                <td><strong>Rota</strong></td>
                                <td>Mapeamento entre URL e Controller</td>
                            </tr>
                            <tr>
                                <td><strong>Middleware</strong></td>
                                <td>Filtro executado antes do Controller</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h3>Termos do ProjetoBase</h3>
                <div class="table-wrapper">
                    <table class="feature-table">
                        <thead>
                            <tr>
                                <th>Termo</th>
                                <th>Significado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>CRUD</strong></td>
                                <td>Create, Read, Update, Delete</td>
                            </tr>
                            <tr>
                                <td><strong>PDO</strong></td>
                                <td>PHP Data Objects - Conexão com banco de dados</td>
                            </tr>
                            <tr>
                                <td><strong>Helper</strong></td>
                                <td>Funções auxiliares reutilizáveis</td>
                            </tr>
                            <tr>
                                <td><strong>CSRF</strong></td>
                                <td>Cross-Site Request Forgery - Proteção contra ataques</td>
                            </tr>
                            <tr>
                                <td><strong>XSS</strong></td>
                                <td>Cross-Site Scripting - Injeção de scripts maliciosos</td>
                            </tr>
                            <tr>
                                <td><strong>Session</strong></td>
                                <td>Armazenamento temporário de dados do usuário</td>
                            </tr>
                            <tr>
                                <td><strong>Flash</strong></td>
                                <td>Mensagem temporária exibida uma vez</td>
                            </tr>
                            <tr>
                                <td><strong>Hash</strong></td>
                                <td>Senha criptografada (password_hash)</td>
                            </tr>
                            <tr>
                                <td><strong>Token</strong></td>
                                <td>Código único para verificação/redefinição</td>
                            </tr>
                            <tr>
                                <td><strong>Middleware</strong></td>
                                <td>Camada intermediária entre requisição e resposta</td>
                            </tr>
                            <tr>
                                <td><strong>.env</strong></td>
                                <td>Arquivo de configuração de ambiente</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h4>Dicas para iniciantes</h4>
                <ul>
                    <li><strong>Comece pelo menu:</strong> Aprenda a adicionar itens no <code>menu.php</code></li>
                    <li><strong>Entenda o fluxo:</strong> Rota → Controller → Model → View</li>
                    <li><strong>Use os Helpers:</strong> Eles facilitam tarefas comuns</li>
                    <li><strong>Consulte o glossário:</strong> Quando encontrar um termo desconhecido</li>
                    <li><strong>Pratique:</strong> Crie uma página simples para entender o fluxo</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================ -->
<!-- RODAPÉ DA PÁGINA                                           -->
<!-- ============================================================ -->
<div class="tutorial-footer">
    <div class="container">
        <div class="footer-credits">
            <a href="https://josealvesdev.com/" target="_blank" rel="noopener noreferrer" class="btn-credits large">
                <span class="credit-text">Criado e pensado por</span>
                <span class="credit-name">
                    <span class="code-tag">&lt;/&gt;</span>
                    Jose Augusto Alves
                </span>
                <span class="credit-arrow">
                    <i class="fas fa-arrow-right"></i>
                </span>
            </a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>