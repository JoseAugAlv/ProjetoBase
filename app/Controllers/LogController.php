<?php
// app/Controllers/LogController.php — auditoria (módulo 'logs')

class LogController extends BaseController
{
    public function index()
    {
        $logModel = new LogSistema();
        $limite = 20;

        $filtros = [
            'buscar' => mb_substr($this->input('buscar'), 0, 100),
            'tabela' => $this->input('tabela'),
            'acao' => $this->input('acao'),
        ];

        $total = $logModel->getTotalWithFilters($filtros);
        $paginacao = PaginationHelper::paginate($total, max(1, $this->inputInt('pagina', 1)), $limite);

        $this->view('logs/index', [
            'logs' => $logModel->getWithFilters($limite, $paginacao['offset'], $filtros),
            'total' => $total,
            'tabelas' => $logModel->getTabelas(),
            'acoes' => $logModel->getAcoes(),
            'paginationHtml' => PaginationHelper::render(url('/logs'), $paginacao['paginaAtual'], $paginacao['totalPaginas'], array_filter($filtros)),
        ]);
    }
}
