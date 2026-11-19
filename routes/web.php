<?php
// routes/web.php — todas as rotas do sistema.
//
// $router->get('/caminho', 'Controller@metodo', [perfis]);
// $router->post('/caminho', 'Controller@metodo', [perfis]);   // CSRF validado automaticamente
// $router->crud('produtos', 'ProdutoController', [perfis]);    // index, criar, salvar, editar, atualizar, excluir
//
// Perfis: Perfil::MASTER (1), Perfil::ADMIN (2), Perfil::OPERADOR (3), Perfil::USUARIO (4)
// Sem perfis = página pública.

$M = Perfil::MASTER;
$A = Perfil::ADMIN;
$O = Perfil::OPERADOR;
$U = Perfil::USUARIO;
$logados = [$M, $A, $O, $U];

// ------------------------------------------------------------
// PÁGINAS PÚBLICAS
// ------------------------------------------------------------
$router->get('/', 'HomeController@index');
$router->get('/home', 'HomeController@index');
$router->get('/sobre', 'SobreController@index');
$router->get('/termos', 'TermosController@index');
$router->get('/tutorial', 'TutorialController@index');

// ------------------------------------------------------------
// AUTENTICAÇÃO
// ------------------------------------------------------------
$router->get('/login', 'AuthController@index');
$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');

$router->get('/login/cadastrar', 'AuthController@cadastrar');
$router->post('/login/salvar', 'AuthController@salvar');

$router->get('/auth/verificar', 'AuthController@verificar');
$router->get('/auth/re-enviar', 'AuthController@reenviarVerificacao');

// Login com Google (só funciona com GOOGLE_CLIENT_ID/SECRET no .env)
$router->get('/auth/google', 'AuthController@google');
$router->get('/auth/google/callback', 'AuthController@googleCallback');

$router->get('/auth/esqueci-senha', 'AuthController@esqueciSenha');
$router->post('/auth/enviar-token', 'AuthController@enviarToken');
$router->get('/auth/redefinir', 'AuthController@redefinir');
$router->post('/auth/redefinir-senha', 'AuthController@redefinirSenha');

// ------------------------------------------------------------
// MINHA CONTA (qualquer usuário logado)
// ------------------------------------------------------------
$router->get('/user', 'UserController@index', $logados);
$router->get('/user/editar', 'UserController@editar', $logados);
$router->post('/user/atualizar', 'UserController@atualizar', $logados);

// ------------------------------------------------------------
// NOTIFICAÇÕES
// ------------------------------------------------------------
$router->get('/notificacoes', 'NotificacaoController@index', $logados);
$router->get('/notificacoes/contador', 'NotificacaoController@contador', $logados);
$router->post('/notificacoes/marcar-lida', 'NotificacaoController@marcarLida', $logados);
$router->post('/notificacoes/marcar-todas-lidas', 'NotificacaoController@marcarTodasLidas', $logados);

// ------------------------------------------------------------
// GESTÃO DE USUÁRIOS (Master e Admin; hierarquia checada no controller)
// ------------------------------------------------------------
$router->get('/usuarios', 'UsuarioController@index', [$M, $A]);
$router->get('/usuarios/criar', 'UsuarioController@criar', [$M, $A]);
$router->post('/usuarios/salvar', 'UsuarioController@salvar', [$M, $A]);
$router->get('/usuarios/editar', 'UsuarioController@editar', [$M, $A]);
$router->post('/usuarios/atualizar', 'UsuarioController@atualizar', [$M, $A]);
$router->post('/usuarios/excluir', 'UsuarioController@excluir', [$M, $A]);
$router->post('/usuarios/atribuir-perfil', 'UsuarioController@atribuirPerfil', [$M, $A]);

$router->get('/dashboard', 'HomeController@dashboard', [$M, $A]);

// ------------------------------------------------------------
// RELATÓRIOS
// ------------------------------------------------------------
$router->get('/relatorios/usuarios', 'RelatoriosController@usuarios', [$M, $A]);
$router->get('/relatorios/exportar', 'RelatoriosController@exportar', [$M, $A]);
$router->get('/relatorios/pdf', 'RelatoriosController@pdf', [$M, $A]);

// ------------------------------------------------------------
// OPERADOR
// ------------------------------------------------------------
$router->get('/operador/atividades', 'OperadorController@atividades', [$O]);

// ------------------------------------------------------------
// MASTER
// ------------------------------------------------------------
$router->get('/master', 'MasterController@index', [$M]);
$router->get('/master/configuracoes', 'MasterController@configuracoes', [$M]);
$router->get('/master/usuarios', 'MasterController@usuarios', [$M]);

if (MenuHelper::isModuleEnabled('logs')) {
    $router->get('/logs', 'LogController@index', [$M]);
}

if (MenuHelper::isModuleEnabled('backup')) {
    $router->get('/master/backup', 'MasterController@backup', [$M]);
    $router->post('/master/backup/exportar', 'MasterController@exportarBackup', [$M]);
    $router->get('/master/backup/download', 'MasterController@downloadBackup', [$M]);
    $router->post('/master/backup/excluir', 'MasterController@excluirBackup', [$M]);
}

// ------------------------------------------------------------
// CRUD DE EXEMPLO (tabela `exemplo`) — apague quando não precisar
// ------------------------------------------------------------
$router->crud('exemplo', 'ExemploController', [$M, $A]);

// ------------------------------------------------------------
// SUAS ROTAS (php bin/console criar:pagina / criar:crud mostram a linha para colar aqui)
// ------------------------------------------------------------
