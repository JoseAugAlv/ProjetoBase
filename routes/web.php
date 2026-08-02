<?php
// routes/web.php

require_once __DIR__ . '/../app/Helpers/MenuHelper.php';

// CARREGA CONFIGURAÇÕES DE MÓDULOS
$modulesConfig = __DIR__ . '/../app/Config/modules.php';
if (file_exists($modulesConfig)) {
    $modules = require $modulesConfig;
    $modulos = $modules['modules'] ?? [];
} else {
    $modulos = [];
}

// PÁGINAS PÚBLICAS
$router->get('/', 'HomeController@index');
$router->get('/sobre', 'SobreController@index');
$router->get('/termos', 'TermosController@index');
$router->get('/home', 'HomeController@index');

// AUTENTICAÇÃO
$router->get('/login', 'AuthController@index');
$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');

$router->get('/login/cadastrar', 'AuthController@cadastrar');
$router->post('/login/salvar', 'AuthController@salvar');

$router->get('/auth/verificar', 'AuthController@verificar');
$router->get('/auth/re-enviar', 'AuthController@reenviarVerificacao');

$router->get('/auth/esqueci-senha', 'AuthController@esqueciSenha');
$router->post('/auth/enviar-token', 'AuthController@enviarToken');
$router->get('/auth/redefinir', 'AuthController@redefinir');
$router->post('/auth/redefinir-senha', 'AuthController@redefinirSenha');

$router->get('/auth/primeiro-acesso', 'AuthController@primeiroAcesso');
$router->post('/auth/completar-primeiro-acesso', 'AuthController@completarPrimeiroAcesso');

// USUÁRIO (próprio perfil)
$router->get('/user', 'UserController@index', [1, 2, 3, 4]);
$router->get('/user/editar', 'UserController@editar', [1, 2, 3, 4]);
$router->post('/user/atualizar', 'UserController@atualizar', [1, 2, 3, 4]);

// GERENCIAR USUÁRIOS
$router->get('/usuarios', 'UsuarioController@index', [1, 2]);
$router->get('/usuarios/criar', 'UsuarioController@criar', [1, 2]);
$router->post('/usuarios/salvar', 'UsuarioController@salvar', [1, 2]);

$router->get('/usuarios/editar', 'UsuarioController@editar', [1, 2]);
$router->post('/usuarios/atualizar', 'UsuarioController@atualizar', [1, 2]);

$router->get('/usuarios/excluir', 'UsuarioController@excluir', [1]);

$router->post('/usuarios/atribuir-perfil', 'UsuarioController@atribuirPerfilMaster', [1]);
$router->post('/usuarios/atribuir-perfil-admin', 'UsuarioController@atribuirPerfilAdmin', [2]);

// LOGS (apenas se módulo ativo)
if ($modulos['logs'] ?? false) {
    $router->get('/logs', 'LogController@index', [1]);
}

// NOTIFICAÇÕES (todos logados)
$router->get('/notificacoes', 'NotificacaoController@index', [1, 2, 3, 4]);
$router->post('/notificacoes/marcar-lida', 'NotificacaoController@marcarLida', [1, 2, 3, 4]);
$router->post('/notificacoes/marcar-todas-lidas', 'NotificacaoController@marcarTodasLidas', [1, 2, 3, 4]);
$router->get('/notificacoes/contador', 'NotificacaoController@contador', [1, 2, 3, 4]);

// MASTER
$router->get('/master', 'MasterController@index', [1]);
$router->get('/usuarios/pendentes', 'UsuarioController@pendentes', [1]);

if ($modulos['backup'] ?? false) {
    $router->get('/master/backup', 'MasterController@backup', [1]);
    $router->post('/master/backup/exportar', 'MasterController@exportarBackup', [1]);
    $router->get('/master/backup/download', 'MasterController@downloadBackup', [1]);
    $router->get('/master/backup/excluir', 'MasterController@excluirBackup', [1]);
}

$router->get('/master/configuracoes', 'MasterController@configuracoes', [1]);
$router->get('/master/usuarios', 'MasterController@usuarios', [1]);
$router->post('/master/atribuir-perfil', 'MasterController@atribuirPerfil', [1]);

// CRUD GENÉRICO - EXEMPLO
// Descomente para criar um CRUD para a tabela 'exemplo'
/*
require_once __DIR__ . '/../app/Helpers/DynamicCrudHelper.php';

DynamicCrudHelper::registerRoutes($router, 'exemplo', 'ExemploController', [1, 2]);

// OU registre manualmente:
$router->get('/exemplo', 'ExemploController@index', [1, 2]);
$router->get('/exemplo/criar', 'ExemploController@criar', [1, 2]);
$router->post('/exemplo/salvar', 'ExemploController@salvar', [1, 2]);
$router->get('/exemplo/editar', 'ExemploController@editar', [1, 2]);
$router->post('/exemplo/atualizar', 'ExemploController@atualizar', [1, 2]);
$router->get('/exemplo/excluir', 'ExemploController@excluir', [1, 2]);
*/

// RELATÓRIOS (apenas Admin)
$router->get('/relatorios/usuarios', 'RelatoriosController@usuarios', [2]);
$router->get('/relatorios/exportar', 'RelatoriosController@exportar', [2]);
$router->get('/relatorios/pdf', 'RelatoriosController@pdf', [2]);
$router->get('/dashboard', 'HomeController@dashboard', [1, 2]);


// pagina de tutorial
$router->get('/tutorial', 'TutorialController@index');