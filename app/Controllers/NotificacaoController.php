<?php
// app/Controllers/NotificacaoController.php

class NotificacaoController extends BaseController
{
    private $notificacao;

    public function __construct()
    {
        $this->notificacao = new Notificacao();
    }

    public function index()
    {
        $this->view('notificacoes/index', [
            'notificacoes' => $this->notificacao->getByUsuario(Auth::id()),
        ]);
    }

    /** POST — só marca notificações do próprio usuário. */
    public function marcarLida()
    {
        $this->notificacao->marcarComoLida($this->inputInt('id_notificacao'), Auth::id());

        if (Router::isAjax()) {
            $this->json(['ok' => true, 'total' => $this->notificacao->contarNaoLidas(Auth::id())]);
        }
        $this->redirect('/notificacoes');
    }

    /** POST */
    public function marcarTodasLidas()
    {
        $this->notificacao->marcarTodasComoLidas(Auth::id());

        if (Router::isAjax()) {
            $this->json(['ok' => true, 'total' => 0]);
        }
        $this->redirect('/notificacoes');
    }

    /** GET (JSON) — contador para o badge do menu. */
    public function contador()
    {
        $this->json(['total' => $this->notificacao->contarNaoLidas(Auth::id())]);
    }
}
