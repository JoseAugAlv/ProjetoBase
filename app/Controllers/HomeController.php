<?php
// app/Controllers/HomeController.php — página inicial e dashboard.

class HomeController extends BaseController
{
    public function index()
    {
        $this->view('home/index');
    }

    public function dashboard()
    {
        $usuario = new Usuario();
        $this->view('home/dashboard', [
            'totalUsuarios' => $usuario->getTotal(),
            'totalAtivos' => $usuario->getTotalAtivos(),
            'perfis' => $usuario->getCountByPerfil(),
        ]);
    }
}
