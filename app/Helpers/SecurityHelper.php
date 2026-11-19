<?php
// app/Helpers/SecurityHelper.php

class SecurityHelper
{
    /** Compatibilidade: use PasswordHelper::validate(). */
    public static function validarForcaSenha($senha): array
    {
        $r = PasswordHelper::validate((string) $senha);
        return ['valida' => $r['valid'], 'erros' => $r['errors']];
    }

    /**
     * Resolve um nome de arquivo dentro de um diretório, bloqueando path traversal.
     * Retorna o caminho real ou null se inválido/inexistente.
     */
    public static function sanitizarCaminhoArquivo($arquivo, $diretorioBase, $extensoesPermitidas = []): ?string
    {
        $nome = basename((string) $arquivo);
        if (!preg_match('/^[a-zA-Z0-9_\-\.]+$/', $nome) || $nome[0] === '.') {
            return null;
        }

        $base = realpath($diretorioBase);
        $caminho = realpath($diretorioBase . DIRECTORY_SEPARATOR . $nome);
        if ($base === false || $caminho === false || strpos($caminho, $base . DIRECTORY_SEPARATOR) !== 0) {
            return null;
        }

        if ($extensoesPermitidas) {
            $ext = strtolower(pathinfo($caminho, PATHINFO_EXTENSION));
            if (!in_array($ext, $extensoesPermitidas, true)) {
                return null;
            }
        }
        return $caminho;
    }

    /** Confere o tipo real do arquivo (conteúdo), não a extensão enviada. */
    public static function validarMimeArquivo($caminhoTemp, $mimesPermitidos = ['image/jpeg', 'image/png', 'application/pdf']): bool
    {
        if (!function_exists('finfo_open')) {
            // Sem finfo só dá para validar imagens
            return @getimagesize($caminhoTemp) !== false
                && (bool) array_filter($mimesPermitidos, function ($m) {
                    return strpos($m, 'image/') === 0;
                });
        }
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $caminhoTemp);
        finfo_close($finfo);
        return in_array($mime, $mimesPermitidos, true);
    }

    /**
     * Auditoria: grava em logs/auditoria.log e na tabela log_sistema (tela /logs).
     */
    public static function logAuditoria($acao, $usuarioId, $detalhes = '', $tipo = 'info', ?string $tabela = null, ?int $registroId = null): void
    {
        $ip = client_ip();
        // Remove quebras de linha para ninguém forjar linhas falsas no log
        $limpar = function ($v) {
            return str_replace(["\r", "\n"], ' ', (string) $v);
        };

        $logDir = ROOT_PATH . '/logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0750, true);
        }
        $linha = sprintf(
            "[%s] [%s] Usuario:%s | IP:%s | Acao:%s | Detalhes:%s\n",
            date('Y-m-d H:i:s'),
            $limpar($tipo),
            $limpar($usuarioId ?? '-'),
            $ip,
            $limpar($acao),
            $limpar($detalhes)
        );
        @file_put_contents($logDir . '/auditoria.log', $linha, FILE_APPEND | LOCK_EX);

        try {
            (new LogSistema())->registrar(
                (string) $acao,
                $tabela,
                $registroId,
                (string) $detalhes,
                is_numeric($usuarioId) ? (int) $usuarioId : null,
                $ip
            );
        } catch (Throwable $e) {
            error_log('Falha ao gravar auditoria no banco: ' . $e->getMessage());
        }
    }
}
