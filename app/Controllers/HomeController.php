<?php
// app/Controllers/HomeController.php

require_once __DIR__ . '/../Core/App.php';
require_once __DIR__ . '/../Models/Usuario.php';
require_once __DIR__ . '/../Models/Notificacao.php';

class HomeController
{
    private $usuario;

    public function __construct()
    {
        $this->usuario = new Usuario();
    }

    public function index()
    {
        $appName = App::getName();
        $basePath = App::getBasePath();
        
        $tituloPagina = 'Início - ' . $appName;
        
        $totalUsuarios = $this->usuario->getTotal();
        $usuariosAtivos = $this->usuario->getAll();
        $totalAtivos = count($usuariosAtivos);
        
        $usuario = $_SESSION['usuario'] ?? null;
        $totalNotificacoes = 0;
        $perfis = [];
        
        if ($usuario) {
            $notificacao = new Notificacao();
            $totalNotificacoes = $notificacao->contarNaoLidas($usuario['id']);
            
            if ($usuario['role'] == 1) {
                $perfis = $this->usuario->getCountByPerfil();
            }
        }

        require '../app/Views/home/index.php';
    }

    /**
     * Dashboard - Redireciona para o dashboard do HomeController
     */
    public function dashboard()
    {
        if (!isset($_SESSION['usuario'])) {
            header('Location: ' . App::getBasePath() . '/login');
            exit;
        }

        $appName = App::getName();
        $basePath = App::getBasePath();
        
        $totalUsuarios = $this->usuario->getTotal();
        $totalAtivos = $this->usuario->getTotalAtivos();
        $primeiroAcessoPendentes = $this->usuario->contarPrimeiroAcessoPendentes();
        $perfis = $this->usuario->getCountByPerfil();
        
        $tituloPagina = 'Dashboard - ' . $appName;
        $cssPagina = 'home.css';
        
        require '../app/Views/home/dashboard.php';
    }

}