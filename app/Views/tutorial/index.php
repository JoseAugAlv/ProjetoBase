<?php
// ============================================================
// ARQUIVO: app/Views/tutorial/index.php
// ============================================================
// ESTE ARQUIVO É UM TUTORIAL COMPLETO SOBRE O PROJETOBASE
// ELE EXPLICA TODOS OS CONCEITOS DE POO, MVC E O FUNCIONAMENTO
// DO SISTEMA. CADA LINHA É COMENTADA EM DETALHE.
// ============================================================

// ============================================================
// 1. CONFIGURAÇÃO DA PÁGINA
// ============================================================
// Estas variáveis são usadas pelo layout (header e nav)
// para definir o título da página e o arquivo CSS específico

// Define o título da página que aparecerá na aba do navegador
// App::getName() retorna o nome do sistema definido no .env
$tituloPagina = 'Tutorial Completo - ' . App::getName();

// Define qual arquivo CSS será carregado para esta página
// O CSS fica em public/css/tutorial.css
$cssPagina = 'tutorial.css';

// ============================================================
// 2. CARREGA O LAYOUT
// ============================================================
// header.php contém o <head> e a abertura do <body>
// nav.php contém o menu de navegação
require_once __DIR__ . '/../layouts/header.php';
require_once __DIR__ . '/../layouts/nav.php';

// ============================================================
// 3. VARIÁVEIS AUXILIARES
// ============================================================
// App::getBasePath() retorna o caminho base do projeto
// Exemplo: /ProjetoBase
// Isso garante que os links funcionem mesmo se o projeto
// estiver em uma subpasta
$basePath = App::getBasePath();

// App::getName() retorna o nome do sistema
$appName = App::getName();

// ============================================================
// 4. INÍCIO DO CONTEÚDO DA PÁGINA
// ============================================================
// Agora começa o HTML da página tutorial
// Cada seção é explicada em detalhes
?>

<!-- ============================================================ -->
<!-- SEÇÃO 1: BANNER/CABEÇALHO PRINCIPAL                        -->
<!-- ============================================================ -->
<!-- 
    Esta é a seção de introdução do tutorial.
    Ela contém o título principal, uma descrição geral
    e o botão de créditos para o desenvolvedor.
-->
<section class="tutorial-banner animate-in">
    <div class="container">
        <div class="banner-content">
            
            <!-- ============================================================ -->
            <!-- ÍCONE DO TUTORIAL                                         -->
            <!-- ============================================================ -->
            <!-- 
                Font Awesome é usado para ícones.
                fa-graduation-cap é um ícone de capelo (formatura)
                que simboliza aprendizado.
            -->
            <div class="banner-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>

            <!-- ============================================================ -->
            <!-- TÍTULO PRINCIPAL                                          -->
            <!-- ============================================================ -->
            <!-- 
                O título usa a classe .gradient-text que aplica
                um degrade de cores no texto.
                O <span> destaca a palavra "Completo" com cor verde.
            -->
            <h1 class="banner-title">
                TUTORIAL <span>COMPLETO</span>
            </h1>
            
            <!-- ============================================================ -->
            <!-- SUBTÍTULO                                                -->
            <!-- ============================================================ -->
            <!-- 
                Mostra o nome do sistema e a arquitetura usada.
                POO = Programação Orientada a Objetos
                MVC = Model-View-Controller
            -->
            <p class="banner-subtitle">
                <?= strtoupper($appName) ?> • POO + MVC
            </p>
            
            <!-- ============================================================ -->
            <!-- DESCRIÇÃO                                                -->
            <!-- ============================================================ -->
            <!-- 
                Explica o propósito do tutorial.
                "Guia Definitivo para Iniciantes" mostra que é para iniciantes.
                "Tudo Explicado Passo a Passo" mostra que é detalhado.
            -->
            <p class="banner-description">
                Guia Definitivo para Iniciantes - Tudo Explicado Passo a Passo
            </p>

            <!-- ============================================================ -->
            <!-- BOTÃO DE CRÉDITOS                                          -->
            <!-- ============================================================ -->
            <!-- 
                Este é um botão estilizado que leva ao portfólio do 
                desenvolvedor. O texto "Criado e pensado por" é seguido
                pelo nome do desenvolvedor com tags HTML estilizadas.
                
                O target="_blank" abre o link em uma nova aba.
                O rel="noopener noreferrer" é uma prática de segurança.
            -->
            <a href="https://josealvesdev.com/" 
               target="_blank" 
               rel="noopener noreferrer"
               class="btn-credits">
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
</section>

<!-- ============================================================ -->
<!-- SEÇÃO 2: ÍNDICE                                             -->
<!-- ============================================================ -->
<!-- 
    O índice lista todos os tópicos do tutorial.
    Cada item é um link que leva a uma seção específica
    da página usando âncoras (IDs).
-->
<section class="tutorial-section animate-in delay-1">
    <div class="container">
        
        <!-- ============================================================ -->
        <!-- TÍTULO DA SEÇÃO                                           -->
        <!-- ============================================================ -->
        <div class="section-header">
            <h2>
                <i class="fas fa-list-ul"></i>
                ÍNDICE
            </h2>
            <p>Navegue pelos tópicos do tutorial</p>
        </div>

        <!-- ============================================================ -->
        <!-- LISTA DE TÓPICOS                                           -->
        <!-- ============================================================ -->
        <!-- 
            Cada item usa um <a> com href="#id-da-secao"
            para fazer scroll suave até a seção correspondente.
        -->
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
<!-- SEÇÃO 3: INTRODUÇÃO AO PROJETOBASE                          -->
<!-- ============================================================ -->
<!-- 
    ID = introducao - usado para navegação pelo índice.
    A classe .tutorial-section define o estilo da seção.
    .animate-in e .delay-2 controlam a animação de entrada.
-->
<section id="introducao" class="tutorial-section animate-in delay-2">
    <div class="container">
        
        <!-- ============================================================ -->
        <!-- CABEÇALHO DA SEÇÃO                                        -->
        <!-- ============================================================ -->
        <div class="section-header">
            <h2>
                <i class="fas fa-rocket" style="color: var(--color-impact-green);"></i>
                1. Introdução ao ProjetoBase
            </h2>
            <p>O que é o ProjetoBase e como ele funciona</p>
        </div>

        <!-- ============================================================ -->
        <!-- CONTEÚDO DA SEÇÃO                                          -->
        <!-- ============================================================ -->
        <div class="section-content">
            
            <!-- ============================================================ -->
            <!-- PARÁGRAFO 1                                              -->
            <!-- ============================================================ -->
            <!-- 
                Explica o que é o ProjetoBase de forma simples.
                Usa analogia da "casa já construída" para facilitar
                o entendimento.
            -->
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
            </div>

            <!-- ============================================================ -->
            <!-- TABELA DE FUNCIONALIDADES                                 -->
            <!-- ============================================================ -->
            <!-- 
                Uma tabela que lista todas as funcionalidades já prontas
                no ProjetoBase. É uma forma visual de mostrar o que o
                sistema já oferece.
            -->
            <div class="content-block">
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
                                <td>Exportar/importar banco de dados</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================ -->
<!-- SEÇÃO 4: ESTRUTURA DO PROJETO                               -->
<!-- ============================================================ -->
<!-- 
    Esta seção explica a estrutura de diretórios do projeto.
    É importante para entender onde cada coisa fica.
-->
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
            
            <!-- ============================================================ -->
            <!-- EXPLICAÇÃO DA ESTRUTURA                                   -->
            <!-- ============================================================ -->
            <div class="content-block">
                <h3>Árvore de Diretórios - Explicada</h3>
                <p>
                    Abaixo está a estrutura completa do ProjetoBase. Cada pasta 
                    e arquivo tem uma função específica no sistema.
                </p>

                <!-- ============================================================ -->
                <!-- ÁRVORE DO PROJETO                                         -->
                <!-- ============================================================ -->
                <!-- 
                    Esta é uma representação visual da estrutura de pastas.
                    Cada pasta é explicada em uma lista abaixo.
                -->
                <div class="tree-container">
                    <pre class="tree-structure">
ProjetoBase/
├── app/                         # Código fonte da aplicação
│   ├── Config/                  # Arquivos de configuração
│   │   ├── config.php           # Configuração geral (carrega .env)
│   │   ├── database.php         # Conexão com o banco de dados (PDO)
│   │   ├── menu.php             # Configuração do menu dinâmico
│   │   └── modules.php          # Ativa/desativa módulos
│   │
│   ├── Controllers/             # Controladores - Lógica da aplicação
│   │   ├── AuthController.php   # Login, cadastro, recuperação
│   │   ├── HomeController.php   # Página inicial
│   │   └── UsuarioController.php # Gerenciar usuários
│   │
│   ├── Core/                    # Núcleo do sistema (não mexer)
│   │   ├── App.php              # Configurações globais
│   │   ├── Router.php           # Sistema de rotas
│   │   ├── Model.php            # Classe base para Models
│   │   └── CrudController.php   # CRUD genérico
│   │
│   ├── Helpers/                 # Funções auxiliares
│   │   ├── MenuHelper.php       # Renderiza o menu
│   │   └── SecurityHelper.php   # Segurança (senha, logs)
│   │
│   ├── Middleware/              # Filtros de requisição
│   │   ├── CsrfMiddleware.php   # Proteção CSRF
│   │   └── AuthMiddleware.php   # Verifica login
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

                <!-- ============================================================ -->
                <!-- LISTA DE PASTAS IMPORTANTES                               -->
                <!-- ============================================================ -->
                <div class="important-folders">
                    <h4>Onde você vai trabalhar mais?</h4>
                    <ul>
                        <li>
                            <strong>app/Controllers/</strong> - 
                            Para criar novas lógicas e funcionalidades
                        </li>
                        <li>
                            <strong>app/Models/</strong> - 
                            Para criar novas tabelas e interagir com o banco
                        </li>
                        <li>
                            <strong>app/Views/</strong> - 
                            Para criar novas páginas HTML
                        </li>
                        <li>
                            <strong>routes/web.php</strong> - 
                            Para criar novas rotas
                        </li>
                        <li>
                            <strong>app/Config/menu.php</strong> - 
                            Para adicionar itens ao menu
                        </li>
                        <li>
                            <strong>.env</strong> - 
                            Para configurar banco de dados e e-mail
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================ -->
<!-- SEÇÃO 5: O QUE É POO                                        -->
<!-- ============================================================ -->
<!-- 
    Esta seção explica Programação Orientada a Objetos
    de forma simples, com analogias e exemplos.
-->
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
            
            <!-- ============================================================ -->
            <!-- ANALOGIA: FÁBRICA DE CARROS                               -->
            <!-- ============================================================ -->
            <div class="content-block">
                <h3>Analogia: Uma Fábrica de Carros</h3>
                <p>
                    Imagine uma <strong>fábrica de carros</strong>. Para produzir um carro, 
                    você não constrói cada peça do zero toda vez. Você tem um 
                    <strong>projeto</strong> (a "classe") que define como um carro deve ser: 
                    quantas rodas, qual motor, quais cores, etc. A partir desse projeto, 
                    você pode fabricar <strong>quantos carros quiser</strong> (os "objetos").
                </p>
                <p>
                    Cada carro produzido é <strong>independente</strong>: pode ser vermelho, 
                    azul, ter motor diferente, mas todos seguem o mesmo projeto base.
                </p>
            </div>

            <!-- ============================================================ -->
            <!-- CONCEITOS FUNDAMENTAIS                                   -->
            <!-- ============================================================ -->
            <div class="content-block">
                <h3>Conceitos Fundamentais da POO</h3>
                
                <!-- ============================================================ -->
                <!-- CONCEITO 1: CLASSE                                        -->
                <!-- ============================================================ -->
                <div class="concept-card">
                    <div class="concept-icon">
                        <i class="fas fa-cube"></i>
                    </div>
                    <div class="concept-content">
                        <h4>1. Classe - O Molde</h4>
                        <p>
                            A <strong>Classe</strong> é como um "molde" ou "projeto" que 
                            define como um objeto deve ser. Ela descreve as 
                            <strong>características</strong> (atributos) e 
                            <strong>comportamentos</strong> (métodos) que os objetos terão.
                        </p>
                        <p class="concept-example">
                            <strong>Exemplo do dia a dia:</strong> 
                            Uma planta de uma casa. A planta não é a casa, mas define 
                            como a casa deve ser construída.
                        </p>
                    </div>
                </div>

                <!-- ============================================================ -->
                <!-- CONCEITO 2: OBJETO                                         -->
                <!-- ============================================================ -->
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
                            <strong>Exemplo do dia a dia:</strong> 
                            A casa construída a partir da planta. Cada casa construída 
                            é um objeto diferente, mas todas seguem a mesma planta.
                        </p>
                    </div>
                </div>

                <!-- ============================================================ -->
                <!-- CONCEITO 3: ATRIBUTO                                       -->
                <!-- ============================================================ -->
                <div class="concept-card">
                    <div class="concept-icon">
                        <i class="fas fa-tag" style="color: #f59e0b;"></i>
                    </div>
                    <div class="concept-content">
                        <h4>3. Atributo - Características</h4>
                        <p>
                            Os <strong>Atributos</strong> são as "características" do 
                            objeto. São as variáveis que definem o estado do objeto.
                        </p>
                        <p class="concept-example">
                            <strong>Exemplo do dia a dia:</strong> 
                            Cor do carro, modelo, ano, velocidade.
                        </p>
                    </div>
                </div>

                <!-- ============================================================ -->
                <!-- CONCEITO 4: MÉTODO                                         -->
                <!-- ============================================================ -->
                <div class="concept-card">
                    <div class="concept-icon">
                        <i class="fas fa-play" style="color: #ef4444;"></i>
                    </div>
                    <div class="concept-content">
                        <h4>4. Método - Ações</h4>
                        <p>
                            Os <strong>Métodos</strong> são as "ações" que o objeto 
                            pode realizar. São as funções que definem o comportamento 
                            do objeto.
                        </p>
                        <p class="concept-example">
                            <strong>Exemplo do dia a dia:</strong> 
                            Acelerar, frear, ligar, desligar.
                        </p>
                    </div>
                </div>
            </div>

            <!-- ============================================================ -->
            <!-- EXEMPLO COMPLETO EM PHP                                    -->
            <!-- ============================================================ -->
            <div class="content-block">
                <h3>Exemplo Completo em PHP - LINHA POR LINHA EXPLICADO</h3>
                <p>
                    Abaixo está um exemplo completo de uma classe Carro em PHP,
                    com cada linha comentada para facilitar o entendimento.
                </p>

                <!-- ============================================================ -->
                <!-- BLOCO DE CÓDIGO                                           -->
                <!-- ============================================================ -->
                <!-- 
                    O código é exibido dentro de um bloco <pre> com a classe
                    .code-block para estilização como um editor de código.
                    Cada seção do código tem comentários explicativos.
                -->
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
    <span class="code-comment">// Atributos são variáveis que pertencem ao objeto</span>
    <span class="code-comment">// "public" significa que podem ser acessados de fora</span>
    <span class="code-keyword">public</span> <span class="code-variable">$cor</span>;        <span class="code-comment">// Cor do carro (ex: "Vermelho")</span>
    <span class="code-keyword">public</span> <span class="code-variable">$marca</span>;      <span class="code-comment">// Marca do carro (ex: "Ferrari")</span>
    <span class="code-keyword">public</span> <span class="code-variable">$velocidade</span> = <span class="code-number">0</span>; <span class="code-comment">// Velocidade atual (começa em 0)</span>

    <span class="code-comment">// ============================================================</span>
    <span class="code-comment">// 3. MÉTODOS (AÇÕES)</span>
    <span class="code-comment">// ============================================================</span>
    <span class="code-comment">// Métodos são funções que pertencem ao objeto</span>
    <span class="code-comment">// $this se refere ao próprio objeto</span>
    
    <span class="code-comment">// Método para acelerar o carro</span>
    <span class="code-keyword">public function</span> <span class="code-method">acelerar</span>() {
        <span class="code-comment">// $this->velocidade acessa a velocidade DESTE carro</span>
        <span class="code-comment">// += 10 aumenta a velocidade em 10 km/h</span>
        <span class="code-variable">$this</span>-><span class="code-variable">velocidade</span> += <span class="code-number">10</span>;
    }

    <span class="code-comment">// Método para mostrar informações do carro</span>
    <span class="code-keyword">public function</span> <span class="code-method">mostrarInfo</span>() {
        <span class="code-comment">// Exibe a marca e a cor do carro</span>
        <span class="code-comment">// { } dentro de string são substituídos pelos valores</span>
        <span class="code-function">echo</span> <span class="code-string">"Carro {$this->marca} na cor {$this->cor}"</span>;
    }
}

<span class="code-comment">// ============================================================</span>
<span class="code-comment">// 4. CRIANDO OBJETOS (INSTÂNCIAS DA CLASSE)</span>
<span class="code-comment">// ============================================================</span>

<span class="code-comment">// A palavra-chave "new" cria um novo objeto</span>
<span class="code-comment">// Cada objeto é independente e tem seus próprios dados</span>

<span class="code-comment">// Criando o primeiro carro (Ferrari Vermelha)</span>
<span class="code-variable">$carro1</span> = <span class="code-keyword">new</span> <span class="code-class">Carro</span>();
<span class="code-variable">$carro1</span>-><span class="code-variable">cor</span> = <span class="code-string">"Vermelho"</span>;    <span class="code-comment">// Define a cor do carro1</span>
<span class="code-variable">$carro1</span>-><span class="code-variable">marca</span> = <span class="code-string">"Ferrari"</span>;   <span class="code-comment">// Define a marca do carro1</span>
<span class="code-variable">$carro1</span>-><span class="code-method">acelerar</span>();          <span class="code-comment">// Chama o método acelerar</span>
<span class="code-comment">// Agora $carro1->velocidade é 10</span>

<span class="code-comment">// Criando o segundo carro (Fusca Azul)</span>
<span class="code-variable">$carro2</span> = <span class="code-keyword">new</span> <span class="code-class">Carro</span>();
<span class="code-variable">$carro2</span>-><span class="code-variable">cor</span> = <span class="code-string">"Azul"</span>;        <span class="code-comment">// Define a cor do carro2</span>
<span class="code-variable">$carro2</span>-><span class="code-variable">marca</span> = <span class="code-string">"Fusca"</span>;     <span class="code-comment">// Define a marca do carro2</span>
<span class="code-comment">// $carro2->velocidade continua 0 (não foi acelerado)</span>

<span class="code-comment">// ============================================================</span>
<span class="code-comment">// 5. EXIBINDO AS INFORMAÇÕES</span>
<span class="code-comment">// ============================================================</span>

<span class="code-comment">// Chama o método mostrarInfo de cada carro</span>
<span class="code-variable">$carro1</span>-><span class="code-method">mostrarInfo</span>(); <span class="code-comment">// Exibe: "Carro Ferrari na cor Vermelho"</span>
<span class="code-variable">$carro2</span>-><span class="code-method">mostrarInfo</span>(); <span class="code-comment">// Exibe: "Carro Fusca na cor Azul"</span></pre>
                </div>
            </div>

            <!-- ============================================================ -->
            <!-- VANTAGENS DA POO                                           -->
            <!-- ============================================================ -->
            <div class="content-block">
                <h3>Por que usar POO? - Vantagens Explicadas</h3>
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
                                <td>O código fica mais organizado e fácil de entender</td>
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
<!-- 
    Explica os 4 pilares da POO com analogias e exemplos.
-->
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
            
            <!-- ============================================================ -->
            <!-- PILAR 1: ENCAPSULAMENTO                                   -->
            <!-- ============================================================ -->
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
                        <strong>Analogia:</strong> 
                        Uma máquina de café. Você não precisa saber como ela funciona 
                        por dentro. Você apenas coloca o pó, a água e aperta o botão. 
                        A máquina faz o trabalho internamente.
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
                </div>
            </div>

            <!-- ============================================================ -->
            <!-- PILAR 2: HERANÇA                                           -->
            <!-- ============================================================ -->
            <div class="pilar-card">
                <div class="pilar-header">
                    <span class="pilar-number">02</span>
                    <h3>Herança</h3>
                </div>
                <div class="pilar-body">
                    <p>
                        <strong>Herança</strong> é um mecanismo que permite criar uma nova 
                        classe baseada em uma classe existente. A nova classe 
                        (chamada de <strong>subclasse</strong> ou <strong>classe filha</strong>) 
                        herda todos os atributos e métodos da classe original.
                    </p>
                    <div class="pilar-analogy">
                        <strong>Analogia:</strong> 
                        Você herda características dos seus pais: cor dos olhos, 
                        tipo de cabelo, etc. Mas você também tem características 
                        únicas que seus pais não têm.
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
    <span class="code-comment">// Atributo exclusivo do cachorro</span>
    <span class="code-keyword">public</span> <span class="code-variable">$raca</span>;
    
    <span class="code-comment">// Método exclusivo do cachorro</span>
    <span class="code-keyword">public function</span> <span class="code-method">latir</span>() {
        <span class="code-function">echo</span> <span class="code-string">"{$this->nome} está latindo: Au Au!"</span>;
    }
}</pre>
                    </div>
                </div>
            </div>

            <!-- ============================================================ -->
            <!-- PILAR 3: POLIMORFISMO                                     -->
            <!-- ============================================================ -->
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
                        <strong>Analogia:</strong> 
                        Todo controle remoto tem um botão "ligar". Mas o comportamento 
                        é diferente para cada aparelho: na TV acende a tela, no ar 
                        condicionado começa a refrigerar, no som começa a tocar música.
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
                </div>
            </div>

            <!-- ============================================================ -->
            <!-- PILAR 4: ABSTRAÇÃO                                         -->
            <!-- ============================================================ -->
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
                        <strong>Analogia:</strong> 
                        Um celular. Você não precisa saber como o processador funciona 
                        para fazer uma ligação. Você só precisa saber que para ligar 
                        digita o número e aperta o botão verde.
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
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================ -->
<!-- SEÇÃO 7: ENTENDENDO O MVC                                  -->
<!-- ============================================================ -->
<!-- 
    Explica o padrão de arquitetura MVC com diagramas e exemplos.
-->
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

                <!-- ============================================================ -->
                <!-- DIAGRAMA MVC                                              -->
                <!-- ============================================================ -->
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

                <!-- ============================================================ -->
                <!-- EXPLICAÇÃO DE CADA PARTE                                 -->
                <!-- ============================================================ -->
                <div class="mvc-parts">
                    <div class="mvc-part">
                        <h4>1. Model (Modelo)</h4>
                        <p>
                            O <strong>Model</strong> é responsável por 
                            <strong>gerenciar os dados</strong> e as 
                            <strong>regras de negócio</strong>. Ele se comunica 
                            diretamente com o banco de dados.
                        </p>
                        <ul>
                            <li>Busca dados no banco de dados</li>
                            <li>Insere, atualiza e deleta registros</li>
                            <li>Valida dados antes de salvar</li>
                            <li>Contém as regras de negócio</li>
                        </ul>
                        <p class="mvc-example">
                            <strong>Exemplo:</strong> A classe <code>Usuario</code> 
                            que busca usuários no banco.
                        </p>
                    </div>

                    <div class="mvc-part">
                        <h4>2. View (Visão)</h4>
                        <p>
                            A <strong>View</strong> é responsável por 
                            <strong>exibir os dados</strong> para o usuário. 
                            É a interface que o usuário vê e interage.
                        </p>
                        <ul>
                            <li>Exibe dados recebidos do Controller</li>
                            <li>Contém HTML, CSS e JavaScript</li>
                            <li>Apresenta formulários para o usuário</li>
                            <li>Não deve ter lógica complexa</li>
                        </ul>
                        <p class="mvc-example">
                            <strong>Exemplo:</strong> O arquivo 
                            <code>usuarios/index.php</code> que lista os usuários.
                        </p>
                    </div>

                    <div class="mvc-part">
                        <h4>3. Controller (Controlador)</h4>
                        <p>
                            O <strong>Controller</strong> é o 
                            <strong>intermediário</strong> entre o Model e a View. 
                            Ele recebe as requisições do usuário, processa os dados 
                            e decide qual View será exibida.
                        </p>
                        <ul>
                            <li>Recebe requisições HTTP (GET, POST, etc)</li>
                            <li>Chama os métodos do Model</li>
                            <li>Prepara os dados para a View</li>
                            <li>Redireciona o usuário quando necessário</li>
                        </ul>
                        <p class="mvc-example">
                            <strong>Exemplo:</strong> A classe 
                            <code>UsuarioController</code> que gerencia os usuários.
                        </p>
                    </div>
                </div>

                <!-- ============================================================ -->
                <!-- FLUXO DE REQUISIÇÃO                                       -->
                <!-- ============================================================ -->
                <div class="content-block">
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
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================ -->
<!-- SEÇÃO 8: CRIANDO UM CRUD COMPLETO                          -->
<!-- ============================================================ -->
<!-- 
    Explica como criar um CRUD completo usando o CRUD genérico.
-->
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

                <h3>Método 1: Usando o CRUD Genérico (Recomendado)</h3>
                
                <h4>Passo 1: Criar o Controller</h4>
                <div class="code-block">
                    <pre><span class="code-comment">// ============================================================</span>
<span class="code-comment">// ARQUIVO: app/Controllers/ProdutoController.php</span>
<span class="code-comment">// ============================================================</span>
<span class="code-comment">// Este controller gerencia produtos usando o CRUD genérico</span>

<span class="code-keyword">require_once</span> <span class="code-string">__DIR__ . '/../Core/CrudController.php'</span>;

<span class="code-keyword">class</span> <span class="code-class">ProdutoController</span> <span class="code-keyword">extends</span> <span class="code-class">CrudController</span>
{
    <span class="code-keyword">public function</span> <span class="code-method">__construct</span>()
    {
        <span class="code-comment">// ============================================================</span>
        <span class="code-comment">// CONFIGURAÇÃO DA TABELA</span>
        <span class="code-comment">// ============================================================</span>
        <span class="code-comment">// Define qual tabela do banco será gerenciada</span>
        <span class="code-variable">$this</span>-><span class="code-variable">table</span> = <span class="code-string">'produto'</span>;
        
        <span class="code-comment">// Define qual é a chave primária da tabela</span>
        <span class="code-variable">$this</span>-><span class="code-variable">primaryKey</span> = <span class="code-string">'id_produto'</span>;

        <span class="code-comment">// ============================================================</span>
        <span class="code-comment">// CAMPOS DA TABELA</span>
        <span class="code-comment">// ============================================================</span>
        <span class="code-comment">// Lista todos os campos que serão exibidos no formulário</span>
        <span class="code-variable">$this</span>-><span class="code-variable">fields</span> = [
            <span class="code-string">'nome'</span>,        <span class="code-comment">// Nome do produto</span>
            <span class="code-string">'descricao'</span>,   <span class="code-comment">// Descrição do produto</span>
            <span class="code-string">'preco'</span>,       <span class="code-comment">// Preço do produto</span>
            <span class="code-string">'quantidade'</span>,  <span class="code-comment">// Quantidade em estoque</span>
            <span class="code-string">'status'</span>       <span class="code-comment">// Status do produto (ativo/inativo)</span>
        ];

        <span class="code-comment">// ============================================================</span>
        <span class="code-comment">// CAMPOS OBRIGATÓRIOS</span>
        <span class="code-comment">// ============================================================</span>
        <span class="code-variable">$this</span>-><span class="code-variable">requiredFields</span> = [
            <span class="code-string">'nome'</span>,   <span class="code-comment">// Nome é obrigatório</span>
            <span class="code-string">'preco'</span>   <span class="code-comment">// Preço é obrigatório</span>
        ];

        <span class="code-comment">// ============================================================</span>
        <span class="code-comment">// PERFIS PERMITIDOS</span>
        <span class="code-comment">// ============================================================</span>
        <span class="code-comment">// Quem pode acessar este CRUD (1=Master, 2=Admin)</span>
        <span class="code-variable">$this</span>-><span class="code-variable">allowedRoles</span> = [1, 2];

        <span class="code-comment">// ============================================================</span>
        <span class="code-comment">// CONFIGURAÇÕES DE EXIBIÇÃO</span>
        <span class="code-comment">// ============================================================</span>
        <span class="code-variable">$this</span>-><span class="code-variable">labelSingular</span> = <span class="code-string">'Produto'</span>;
        <span class="code-variable">$this</span>-><span class="code-variable">labelPlural</span> = <span class="code-string">'Produtos'</span>;
        <span class="code-variable">$this</span>-><span class="code-variable">perPage</span> = <span class="code-number">20</span>;

        <span class="code-comment">// ============================================================</span>
        <span class="code-comment">// ORDENAÇÃO PADRÃO</span>
        <span class="code-comment">// ============================================================</span>
        <span class="code-variable">$this</span>-><span class="code-variable">defaultSort</span> = <span class="code-string">'nome'</span>;
        <span class="code-variable">$this</span>-><span class="code-variable">defaultOrder</span> = <span class="code-string">'ASC'</span>;

        <span class="code-comment">// ============================================================</span>
        <span class="code-comment">// CHAMA O CONSTRUTOR DA CLASSE PAI</span>
        <span class="code-comment">// ============================================================</span>
        <span class="code-keyword">parent</span>::<span class="code-method">__construct</span>();
    }
}</pre>
                </div>

                <h4>Passo 2: Registrar as Rotas</h4>
                <div class="code-block mini">
                    <pre><span class="code-comment">// ============================================================</span>
<span class="code-comment">// ARQUIVO: routes/web.php</span>
<span class="code-comment">// ============================================================</span>

<span class="code-comment">// Método automático (recomendado)</span>
<span class="code-keyword">require_once</span> <span class="code-string">__DIR__ . '/../app/Core/DynamicCrudHelper.php'</span>;
<span class="code-class">DynamicCrudHelper</span>::<span class="code-method">registerRoutes</span>(<span class="code-variable">$router</span>, <span class="code-string">'produto'</span>, <span class="code-string">'ProdutoController'</span>, [1, 2]);

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

                <h4>Passo 3: Criar a Tabela</h4>
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

<span class="code-comment"># Host do banco de dados</span>
<span class="code-keyword">DB_HOST</span>=127.0.0.1

<span class="code-comment"># Porta do banco de dados (padrão MySQL é 3306)</span>
<span class="code-keyword">DB_PORT</span>=3306

<span class="code-comment"># Nome do banco de dados</span>
<span class="code-keyword">DB_NAME</span>=meu_projeto

<span class="code-comment"># Usuário do banco de dados</span>
<span class="code-keyword">DB_USER</span>=root

<span class="code-comment"># Senha do banco de dados</span>
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
        <span class="code-string">'uploads'</span> => <span class="code-keyword">true</span>,      <span class="code-comment">// Ativa upload de arquivos</span>
    ],
];</pre>
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
            <span class="code-string">'label'</span> => <span class="code-string">'Início'</span>,           <span class="code-comment">// Texto que aparece no menu</span>
            <span class="code-string">'icon'</span> => <span class="code-string">'fas fa-home'</span>,       <span class="code-comment">// Ícone Font Awesome</span>
            <span class="code-string">'url'</span> => <span class="code-string">'/'</span>,                  <span class="code-comment">// URL do item</span>
            <span class="code-string">'roles'</span> => [1, 2, 3, 4],       <span class="code-comment">// Quem pode ver (todos)</span>
        ],
        
        <span class="code-comment">// ============================================================</span>
        <span class="code-comment">// ITEM COM SUBMENU</span>
        <span class="code-comment">// ============================================================</span>
        [
            <span class="code-string">'label'</span> => <span class="code-string">'Administração'</span>,    <span class="code-comment">// Texto do menu principal</span>
            <span class="code-string">'icon'</span> => <span class="code-string">'fas fa-cog'</span>,        <span class="code-comment">// Ícone do menu principal</span>
            <span class="code-string">'roles'</span> => [1, 2],             <span class="code-comment">// Quem pode ver (Admin e Master)</span>
            <span class="code-string">'subitems'</span> => [                <span class="code-comment">// Subitens do menu</span>
                [
                    <span class="code-string">'label'</span> => <span class="code-string">'Usuários'</span>,
                    <span class="code-string">'icon'</span> => <span class="code-string">'fas fa-users'</span>,
                    <span class="code-string">'url'</span> => <span class="code-string">'/usuarios'</span>,
                    <span class="code-string">'roles'</span> => [1, 2],
                ],
            ],
        ],
        
        <span class="code-comment">// ============================================================</span>
        <span class="code-comment">// ITEM COM MÓDULO (só aparece se módulo estiver ativo)</span>
        <span class="code-comment">// ============================================================</span>
        [
            <span class="code-string">'label'</span> => <span class="code-string">'Logs'</span>,
            <span class="code-string">'icon'</span> => <span class="code-string">'fas fa-history'</span>,
            <span class="code-string">'url'</span> => <span class="code-string">'/logs'</span>,
            <span class="code-string">'roles'</span> => [1],
            <span class="code-string">'module'</span> => <span class="code-string">'logs'</span>,            <span class="code-comment">// Só aparece se módulo logs estiver ativo</span>
        ],
    ],
];</pre>
                </div>
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
                <h3>Ativando/Desativando Módulos</h3>
                <div class="code-block mini">
                    <pre><span class="code-comment">// ============================================================</span>
<span class="code-comment">// ARQUIVO: app/Config/modules.php</span>
<span class="code-comment">// ============================================================</span>

<span class="code-keyword">return</span> [
    <span class="code-string">'modules'</span> => [
        <span class="code-comment">// true = ativado, false = desativado</span>
        <span class="code-string">'logs'</span> => <span class="code-keyword">true</span>,
        <span class="code-string">'backup'</span> => <span class="code-keyword">true</span>,
        <span class="code-string">'api'</span> => <span class="code-keyword">false</span>,
        <span class="code-string">'export'</span> => <span class="code-keyword">true</span>,
        <span class="code-string">'uploads'</span> => <span class="code-keyword">true</span>,
    ],
];</pre>
                </div>

                <h3>Verificando se um Módulo está Ativo</h3>
                <div class="code-block mini">
                    <pre><span class="code-comment">// Em qualquer lugar do código</span>

<span class="code-comment">// Verifica se o módulo de logs está ativo</span>
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
}</pre>
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
                <h3>Sistema de Perfis</h3>
                <p>Os perfis são definidos no banco de dados:</p>
                <div class="code-block mini">
                    <pre><span class="code-comment">-- ============================================================</span>
<span class="code-comment">-- TABELA PERFIL</span>
<span class="code-comment">-- ============================================================</span>
<span class="code-keyword">CREATE TABLE</span> perfil (
    <span class="code-variable">id_perfil</span> <span class="code-keyword">INT PRIMARY KEY AUTO_INCREMENT</span>,
    <span class="code-variable">perfil</span> <span class="code-keyword">VARCHAR(20) UNIQUE NOT NULL</span>
);

<span class="code-comment">-- ============================================================</span>
<span class="code-comment">-- PERFIS PADRÃO</span>
<span class="code-comment">-- ============================================================</span>
<span class="code-keyword">INSERT INTO</span> perfil <span class="code-keyword">VALUES</span>
(1, <span class="code-string">'Master'</span>),    <span class="code-comment">-- Acesso total</span>
(2, <span class="code-string">'Admin'</span>),     <span class="code-comment">-- Gerencia usuários</span>
(3, <span class="code-string">'Operador'</span>),  <span class="code-comment">-- Operações básicas</span>
(4, <span class="code-string">'Usuario'</span>);   <span class="code-comment">-- Acesso restrito</span></pre>
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
<span class="code-variable">$router</span>-><span class="code-method">get</span>(<span class="code-string">'/user'</span>, <span class="code-string">'UserController@index'</span>, [1, 2, 3, 4]);</pre>
                </div>

                <h4>2. Nos Controllers</h4>
                <div class="code-block mini">
                    <pre><span class="code-keyword">public function</span> <span class="code-method">index</span>()
{
    <span class="code-comment">// ============================================================</span>
    <span class="code-comment">// 1. VERIFICA SE ESTÁ LOGADO</span>
    <span class="code-comment">// ============================================================</span>
    <span class="code-keyword">if</span> (!<span class="code-keyword">isset</span>(<span class="code-variable">$_SESSION</span>[<span class="code-string">'usuario'</span>])) {
        <span class="code-method">header</span>(<span class="code-string">'Location: ' . App::getBasePath() . '/login'</span>);
        <span class="code-keyword">exit</span>;
    }

    <span class="code-comment">// ============================================================</span>
    <span class="code-comment">// 2. VERIFICA O PERFIL</span>
    <span class="code-comment">// ============================================================</span>
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
                <h3>Lista de Helpers Disponíveis</h3>
                <div class="table-wrapper">
                    <table class="feature-table">
                        <thead>
                            <tr>
                                <th>Helper</th>
                                <th>Função</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>MenuHelper</strong></td>
                                <td>Renderiza o menu dinâmico</td>
                            </tr>
                            <tr>
                                <td><strong>SecurityHelper</strong></td>
                                <td>Valida senha, sanitiza arquivos, logs</td>
                            </tr>
                            <tr>
                                <td><strong>UploadHelper</strong></td>
                                <td>Upload de arquivos com segurança</td>
                            </tr>
                            <tr>
                                <td><strong>PaginationHelper</strong></td>
                                <td>Paginação de resultados</td>
                            </tr>
                            <tr>
                                <td><strong>ViewHelper</strong></td>
                                <td>CSRF field, formatação de data/moeda</td>
                            </tr>
                            <tr>
                                <td><strong>ExcelHelper</strong></td>
                                <td>Exportar para Excel</td>
                            </tr>
                            <tr>
                                <td><strong>PdfHelper</strong></td>
                                <td>Exportar para PDF</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h3>Como Usar os Helpers</h3>

                <h4>SecurityHelper - Validar Senha</h4>
                <div class="code-block mini">
                    <pre><span class="code-comment">// A senha deve ter:</span>
<span class="code-comment">// - Mínimo 8 caracteres</span>
<span class="code-comment">// - Pelo menos 1 letra maiúscula</span>
<span class="code-comment">// - Pelo menos 1 letra minúscula</span>
<span class="code-comment">// - Pelo menos 1 número</span>
<span class="code-comment">// - Pelo menos 1 caractere especial</span>

<span class="code-variable">$senha</span> = <span class="code-variable">$_POST</span>[<span class="code-string">'senha'</span>] ?? <span class="code-string">''</span>;
<span class="code-variable">$resultado</span> = <span class="code-class">SecurityHelper</span>::<span class="code-method">validarForcaSenha</span>(<span class="code-variable">$senha</span>);

<span class="code-keyword">if</span> (<span class="code-variable">$resultado</span>[<span class="code-string">'valida'</span>]) {
    <span class="code-comment">// Senha forte - pode salvar</span>
    <span class="code-function">echo</span> <span class="code-string">"Senha válida!"</span>;
} <span class="code-keyword">else</span> {
    <span class="code-comment">// Senha fraca - mostra os erros</span>
    <span class="code-function">echo</span> <span class="code-string">"Senha fraca. Requisitos: " . implode(', ', $resultado['erros'])</span>;
}</pre>
                </div>

                <h4>PaginationHelper - Paginação</h4>
                <div class="code-block mini">
                    <pre><span class="code-comment">// No Controller:</span>
<span class="code-variable">$total</span> = <span class="code-variable">$model</span>-><span class="code-method">getTotal</span>();
<span class="code-variable">$pagina</span> = (<span class="code-keyword">int</span>) (<span class="code-variable">$_GET</span>[<span class="code-string">'pagina'</span>] ?? <span class="code-number">1</span>);
<span class="code-variable">$limite</span> = <span class="code-number">20</span>;

<span class="code-variable">$paginacao</span> = <span class="code-class">PaginationHelper</span>::<span class="code-method">paginate</span>(<span class="code-variable">$total</span>, <span class="code-variable">$pagina</span>, <span class="code-variable">$limite</span>);
<span class="code-variable">$registros</span> = <span class="code-variable">$model</span>-><span class="code-method">getWithPagination</span>(<span class="code-variable">$limite</span>, <span class="code-variable">$paginacao</span>[<span class="code-string">'offset'</span>]);

<span class="code-variable">$paginationHtml</span> = <span class="code-class">PaginationHelper</span>::<span class="code-method">render</span>(
    <span class="code-class">App</span>::<span class="code-method">getBasePath</span>() . <span class="code-string">'/clientes'</span>, <span class="code-comment">// URL base</span>
    <span class="code-variable">$pagina</span>,                           <span class="code-comment">// Página atual</span>
    <span class="code-variable">$paginacao</span>[<span class="code-string">'totalPaginas'</span>]         <span class="code-comment">// Total de páginas</span>
);

<span class="code-comment">// Na View:</span>
&lt;?= <span class="code-variable">$paginationHtml</span> ?&gt;</pre>
                </div>

                <h4>ViewHelper - CSRF e Formatação</h4>
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
                <h3>Passo 1: Criar a Rota</h3>
                <div class="code-block mini">
                    <pre><span class="code-comment">// ============================================================</span>
<span class="code-comment">// ARQUIVO: routes/web.php</span>
<span class="code-comment">// ============================================================</span>

<span class="code-comment">// Cria uma rota GET para a página</span>
<span class="code-variable">$router</span>-><span class="code-method">get</span>(<span class="code-string">'/minha-pagina'</span>, <span class="code-string">'MinhaPaginaController@index'</span>);</pre>
                </div>

                <h3>Passo 2: Criar o Controller</h3>
                <div class="code-block mini">
                    <pre><span class="code-comment">// ============================================================</span>
<span class="code-comment">// ARQUIVO: app/Controllers/MinhaPaginaController.php</span>
<span class="code-comment">// ============================================================</span>

<span class="code-keyword">require_once</span> <span class="code-string">__DIR__ . '/../Core/App.php'</span>;

<span class="code-keyword">class</span> <span class="code-class">MinhaPaginaController</span>
{
    <span class="code-keyword">public function</span> <span class="code-method">index</span>()
    {
        <span class="code-comment">// Define o título da página</span>
        <span class="code-variable">$tituloPagina</span> = <span class="code-string">'Minha Página - ' . App::getName()</span>;
        
        <span class="code-comment">// Define o CSS da página</span>
        <span class="code-variable">$cssPagina</span> = <span class="code-string">'home.css'</span>;
        
        <span class="code-comment">// Carrega a View</span>
        <span class="code-keyword">require_once</span> <span class="code-string">__DIR__ . '/../Views/minha_pagina/index.php'</span>;
    }
}</pre>
                </div>

                <h3>Passo 3: Criar a View</h3>
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
        &lt;p&gt;Conteúdo da minha página.&lt;/p&gt;
        
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
                <div class="code-block mini">
                    <pre><span class="code-comment">// ============================================================</span>
<span class="code-comment">// ARQUIVO: app/Config/menu.php</span>
<span class="code-comment">// ============================================================</span>

[
    <span class="code-string">'label'</span> => <span class="code-string">'Minha Página'</span>,
    <span class="code-string">'icon'</span> => <span class="code-string">'fas fa-file'</span>,
    <span class="code-string">'url'</span> => <span class="code-string">'/minha-pagina'</span>,
    <span class="code-string">'roles'</span> => [1, 2, 3, 4],
],</pre>
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
                                <td>Método executado ao criar o objeto</td>
                            </tr>
                            <tr>
                                <td><strong>Interface</strong></td>
                                <td>Contrato que define métodos obrigatórios</td>
                            </tr>
                            <tr>
                                <td><strong>Classe Abstrata</strong></td>
                                <td>Classe que não pode ser instanciada</td>
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
                                <td>PHP Data Objects - Conexão com banco</td>
                            </tr>
                            <tr>
                                <td><strong>Helper</strong></td>
                                <td>Funções auxiliares</td>
                            </tr>
                            <tr>
                                <td><strong>CSRF</strong></td>
                                <td>Proteção contra ataques de formulário</td>
                            </tr>
                            <tr>
                                <td><strong>Session</strong></td>
                                <td>Armazenamento de dados do usuário</td>
                            </tr>
                            <tr>
                                <td><strong>Flash</strong></td>
                                <td>Mensagem temporária exibida uma vez</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================ -->
<!-- RODAPÉ DA PÁGINA (BOTÃO DE CRÉDITOS)                      -->
<!-- ============================================================ -->
<!-- 
    Este é um botão de créditos que aparece no final da página.
    Ele leva ao portfólio do desenvolvedor.
-->
<div class="tutorial-footer">
    <div class="container">
        <div class="footer-credits">
            <a href="https://josealvesdev.com/" 
               target="_blank" 
               rel="noopener noreferrer"
               class="btn-credits large">
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

<?php
// ============================================================
// 5. CARREGA O FOOTER
// ============================================================
// footer.php contém o fechamento do <body> e </html>
// Além de incluir os scripts JavaScript
require_once __DIR__ . '/../layouts/footer.php';
?>