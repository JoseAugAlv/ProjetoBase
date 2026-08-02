<?php
// app/Controllers/LogController.php

require_once __DIR__ . '/../Core/App.php';
require_once __DIR__ . '/../Models/LogSistema.php';
require_once __DIR__ . '/../Helpers/PaginationHelper.php';

class LogController
{
    public function index()
    {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['role'] != 1) {
            header('Location: ' . App::getBasePath() . '/');
            exit;
        }

        $logModel = new LogSistema();
        $pagina = (int) ($_GET['pagina'] ?? 1);
        $limite = 20;
        
        $total = $logModel->getTotal();
        $paginacao = PaginationHelper::paginate($total, $pagina, $limite);
        $logs = $logModel->getWithPagination($limite, $paginacao['offset']);
        $tabelas = $logModel->getTabelas();
        $acoes = $logModel->getAcoes();
        
        $paginationHtml = PaginationHelper::render(
            App::getBasePath() . '/logs', 
            $pagina, 
            $paginacao['totalPaginas']
        );
        
        $tituloPagina = 'Logs do Sistema - ' . App::getName();
        $cssPagina = 'logs.css';
        
        require_once __DIR__ . '/../Views/logs/index.php';
    }
}