<?php
// app/Helpers/ViewHelper.php
// Formatação para views. Para escapar texto prefira a função curta e($valor).

class ViewHelper
{
    public static function csrfField(): string
    {
        return CsrfMiddleware::field();
    }

    public static function escape($string): string
    {
        return e($string);
    }

    public static function formatDate($date, $format = 'd/m/Y H:i'): string
    {
        if (empty($date) || strpos((string) $date, '0000-00-00') === 0) {
            return '-';
        }
        $ts = strtotime((string) $date);
        return $ts ? date($format, $ts) : '-';
    }

    public static function formatMoney($value): string
    {
        return 'R$ ' . number_format((float) $value, 2, ',', '.');
    }

    public static function statusBadge($status): string
    {
        $classes = [
            'aprovado' => 'badge-success',
            'aprovada' => 'badge-success',
            'ativo' => 'badge-success',
            'pendente' => 'badge-warning',
            'rejeitado' => 'badge-danger',
            'rejeitada' => 'badge-danger',
            'inativo' => 'badge-danger',
            'cancelado' => 'badge-secondary',
            'planejamento' => 'badge-info',
            'finalizado' => 'badge-secondary',
        ];

        $class = $classes[strtolower((string) $status)] ?? 'badge-secondary';
        return "<span class='badge {$class}'>" . e(ucfirst((string) $status)) . '</span>';
    }
}
