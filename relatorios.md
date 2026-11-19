# Relatório de alterações — ProjetoBase

## Núcleo (app/Core, app/bootstrap.php, public/index.php)
- `app/bootstrap.php` (novo): inicialização comum, autoload de classes, tratamento de erros.
- `public/index.php`: usa o bootstrap, buffer de saída, sincroniza usuário logado, headers de segurança.
- `app/Core/App.php`: parser próprio do `.env`, `isDebug()`, `isHttps()`, caminho base corrigido.
- `app/Core/Database.php` (novo, substitui `app/Config/database.php`): conexão utf8mb4 sem vazar dados de erro.
- `app/Core/Router.php`: CSRF automático em todo POST, `crud()`, páginas de erro, redireciona ao login guardando a URL.
- `app/Core/View.php` (novo): renderização de views e página de erro única.
- `app/Core/Auth.php`: login com troca de sessão, logout completo, sincronização de perfil/ativo a cada requisição.
- `app/Core/BaseController.php`: atalhos (`view`, `redirectWith`, `json`, `input`, `log`...). Todos os controllers herdam dele.
- `app/Core/Model.php`: reescrito com consultas seguras, validação de colunas, `paginate` corrigido.
- `app/Core/CrudController.php`: reescrito (antes dava erro fatal); exclusão por POST, selects, checkbox.
- `app/Core/Mail.php`: usa `App::get`, template único de e-mail, e-mails de verificação/boas-vindas.
- Removidos: `app/Core/Perfil.php`, `app/Core/DynamicCrudHelper.php`, `app/Config/config.php`, `app/Config/database.php`.

## Configuração
- `app/Config/SessionConfig.php`: cookie seguro, expiração por inatividade, troca periódica de ID.
- `app/Config/modules.php`: módulos `acessibilidade`, `vlibras`, `login_google`.
- `app/Config/menu.php`: item Exemplo (CRUD), Relatórios para Master e Admin, Exportar PDF.
- `routes/web.php`: reorganizado, exclusões em POST, rotas do Google, CRUD de exemplo, Operador.
- `.env.example`: todas as chaves documentadas (inclui Google). `.env` local: porta 3306 e `APP_ENV=development`.

## Models (um por tabela)
- `Usuario.php`: herda `Model`, validação de dados, whitelist de colunas, `google_id`.
- `Perfil.php` (novo): constantes e regras de hierarquia (quem gerencia quem).
- `ResetSenha.php` (novo): tokens de redefinição com hash e validade no MySQL.
- `Notificacao.php`, `LogSistema.php`, `Exemplo.php`: herdam `Model`; correção de IDOR nas notificações.
- Removido: `Home.php` (vazio).

## Controllers
- `AuthController.php`: rate limit real, proteção de tempo, login com Google, logout com token, sem enumeração de e-mail.
- `UsuarioController.php`: corrigida escalada de privilégio, tela em branco ao criar, exclusão quebrada; envia link para definir senha.
- `UserController.php`: troca de e-mail/senha exige a senha atual.
- `MasterController.php`: backup em caminho seguro, exclusão por POST, validação de nome do arquivo.
- `NotificacaoController.php`, `LogController.php` (filtros funcionando), `RelatoriosController.php`, `HomeController.php`, `OperadorController.php`, `Sobre/Termos/TutorialController.php`, `ExemploController.php`: adaptados ao `BaseController`.
- Removido: `DashboardController.php` (duplicado).

## Helpers e Middleware
- `functions.php` (novo): `e()`, `url()`, `asset()`, `csrf_field()`, `flash()`, `redirect()`, `back()`.
- `GoogleOAuth.php` (novo): login com Google (state + PKCE).
- `RateLimiter.php`: contador em arquivo (antes era na sessão).
- `PasswordHelper.php`, `SecurityHelper.php` (auditoria também no banco), `UploadHelper.php`, `ViewHelper.php`, `PaginationHelper.php`, `ExcelHelper.php` (anti-injeção de fórmula).
- `MenuHelper.php` e `PdfHelper.php`: nomes de arquivo corrigidos (quebrariam no Linux).
- `CsrfMiddleware.php`, `AuthMiddleware.php`: simplificados.
- Removido: `NavHelper.php`.

## Views
- `layouts/header.php`, `nav.php`, `footer.php`: escape de saída, logout protegido, flash central, acessibilidade.
- Novos: `layouts/flash.php`, `layouts/acessibilidade.php`, `errors/erro.php`, `crud/_campos.php`, `auth/_google.php`.
- `crud/*`: reescritas. `master/usuarios.php`: corrigido XSS. `usuarios/*`, `master/backup.php`: exclusão por POST, hierarquia.
- `auth/index.php`: CSS corrigido, botão Google, "Login Rápido" só em desenvolvimento.
- Todas: removidos blocos repetidos (flash, checagem de perfil, requires) e todos os emojis (trocados por ícones).
- Regra de senha no front alinhada ao servidor (mínimo 8).

## Acessibilidade
- `public/css/acessibilidade.css`, `public/js/acessibilidade.js` (novos): tema escuro, tamanho do texto, correção de cores para daltônicos, alto contraste, destacar links. VLibras no rodapé.
- `public/css/style.css`: classe `.sr-only`.

## Banco e console
- `database/schema.sql`, `database/dados_teste.sql` (novos; substituem `ProjetoBase_bd.sql`), `database/migracoes/001_login_google.sql`.
- `bin/console` (novo): `instalar`, `migrar`, `criar-master`, `criar:pagina`, `criar:model`, `criar:crud`, `rotas`.

## Servidor e projeto
- `.htaccess` (raiz e `public/`), `public/uploads/.htaccess`, `backups/.htaccess`, `storage/.htaccess`: bloqueio de arquivos sensíveis e de execução de scripts.
- `.gitignore`: `CLAUDE.md`, `graphify-out/`, dados gerados; corrigida codificação.
- `CLAUDE.md`: mapa atualizado do projeto.
