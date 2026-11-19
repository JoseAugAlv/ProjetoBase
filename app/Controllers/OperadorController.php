<?php
// app/Controllers/OperadorController.php — área do Operador.

class OperadorController extends BaseController
{
    public function atividades()
    {
        $this->view('operador/atividades');
    }
}
