<?php
// app/bootstrap.php
// Carregado por public/index.php (web) e bin/console (terminal).
// Define constantes, autoload, configuração de erros e helpers globais.

define('ROOT_PATH', dirname(__DIR__));
define('APP_PATH', __DIR__);
define('STORAGE_PATH', ROOT_PATH . '/storage');

require_once APP_PATH . '/Core/App.php';
App::init();

// ------------------------------------------------------------
// AUTOLOAD: o nome do arquivo é o nome da classe.
// Ex: new Produto() carrega app/Models/Produto.php
// ------------------------------------------------------------
spl_autoload_register(function (string $classe) {
    if (!preg_match('/^[A-Za-z0-9_]+$/', $classe)) {
        return;
    }
    foreach (['Core', 'Controllers', 'Models', 'Helpers', 'Middleware', 'Config'] as $pasta) {
        $arquivo = APP_PATH . "/{$pasta}/{$classe}.php";
        if (is_file($arquivo)) {
            require_once $arquivo;
            return;
        }
    }
});

if (is_file(ROOT_PATH . '/vendor/autoload.php')) {
    require_once ROOT_PATH . '/vendor/autoload.php';
}

require_once APP_PATH . '/Helpers/functions.php';

date_default_timezone_set(App::get('APP_TIMEZONE', 'America/Sao_Paulo'));
mb_internal_encoding('UTF-8');

// ------------------------------------------------------------
// ERROS: sempre registra em logs/php_errors.log;
// só mostra na tela em desenvolvimento (APP_ENV != production).
// ------------------------------------------------------------
error_reporting(E_ALL);
ini_set('display_errors', App::isDebug() ? '1' : '0');
ini_set('log_errors', '1');
ini_set('error_log', ROOT_PATH . '/logs/php_errors.log');

if (PHP_SAPI !== 'cli') {
    set_exception_handler(function (Throwable $e) {
        error_log('[' . get_class($e) . '] ' . $e->getMessage() . ' em ' . $e->getFile() . ':' . $e->getLine() . "\n" . $e->getTraceAsString());
        View::erro(500, App::isDebug() ? (string) $e : '');
    });
}
