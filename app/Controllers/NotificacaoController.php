<?php
// app/Controllers/NotificacaoController.php

require_once __DIR__ . '/../Core/App.php';
require_once __DIR__ . '/../Models/Notificacao.php';

class NotificacaoController
{
    private $notificacao;

    public function __construct()
    {
        $this->notificacao = new Notificacao();
    }

    /**
     * Lista notificações do usuário
     */
    public function index()
    {
        if (!isset($_SESSION['usuario'])) {
            header('Location: ' . App::getBasePath() . '/login');
            exit;
        }

        $idUsuario = $_SESSION['usuario']['id'];
        $notificacoes = $this->notificacao->getByUsuario($idUsuario);
        $naoLidas = $this->notificacao->contarNaoLidas($idUsuario);

        require '../app/Views/notificacoes/index.php';
    }

    /**
     * Marca notificação como lida (AJAX ou POST)
     */
    public function marcarLida()
    {
        if (!isset($_SESSION['usuario'])) {
            header('Location: ' . App::getBasePath() . '/login');
            exit;
        }

        if (isset($_POST['id_notificacao']) && !empty($_POST['id_notificacao'])) {
            $this->notificacao->marcarComoLida((int) $_POST['id_notificacao']);
        }

        header('Location: ' . App::getBasePath() . '/notificacoes');
        exit;
    }

    /**
     * Marca todas como lidas
     */
    public function marcarTodasLidas()
    {
        if (!isset($_SESSION['usuario'])) {
            header('Location: ' . App::getBasePath() . '/login');
            exit;
        }

        $idUsuario = $_SESSION['usuario']['id'];
        $this->notificacao->marcarTodasComoLidas($idUsuario);

        header('Location: ' . App::getBasePath() . '/notificacoes');
        exit;
    }

    /**
     * Retorna o contador de notificações via AJAX
     */
    public function contador()
    {
        if (!isset($_SESSION['usuario'])) {
            echo json_encode(['total' => 0]);
            exit;
        }

        $idUsuario = $_SESSION['usuario']['id'];
        $total = $this->notificacao->contarNaoLidas($idUsuario);
        
        header('Content-Type: application/json');
        echo json_encode(['total' => $total]);
        exit;
    }
}