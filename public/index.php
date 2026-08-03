<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../app/Config/SessionConfig.php';
SessionConfig::configure();
require_once __DIR__ . '/../app/Core/App.php';
App::init();
require_once __DIR__ . '/../app/Config/config.php';
require_once __DIR__ . '/../app/Config/database.php';
require_once __DIR__ . '/../app/Core/Router.php';
$router = new Router();

require_once __DIR__ . '/../routes/web.php';
$router->dispatch($_SERVER['REQUEST_URI']);
