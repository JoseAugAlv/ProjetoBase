<?php
// app/Helpers/UploadHelper.php
// Upload seguro para public/uploads/{pasta}:
//   $r = UploadHelper::upload($_FILES['foto'], 'fotos', ['jpg', 'png', 'webp']);
//   if ($r['success']) { $caminho = $r['arquivo']; } // salvar no banco; exibir com asset('uploads/' . $caminho)
// Nome do arquivo é sempre gerado (nunca o enviado), tipo real conferido e PHP bloqueado na pasta.

class UploadHelper
{
    private const MIMES = [
        'pdf' => 'application/pdf',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'webp' => 'image/webp',
        'gif' => 'image/gif',
        'zip' => 'application/zip',
    ];

    public static function upload($arquivo, string $pasta, array $tiposPermitidos = ['pdf', 'jpg', 'jpeg', 'png', 'webp'], int $tamanhoMaximo = 2097152): array
    {
        if (!is_array($arquivo) || ($arquivo['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK || !is_uploaded_file($arquivo['tmp_name'])) {
            return ['success' => false, 'message' => 'Erro ao enviar o arquivo.'];
        }

        if (!preg_match('/^[a-zA-Z0-9_\-\/]+$/', $pasta) || strpos($pasta, '..') !== false) {
            return ['success' => false, 'message' => 'Pasta de destino inválida.'];
        }

        $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
        $tiposPermitidos = array_intersect(array_map('strtolower', $tiposPermitidos), array_keys(self::MIMES));
        if (!in_array($extensao, $tiposPermitidos, true)) {
            return ['success' => false, 'message' => 'Formato de arquivo não permitido.'];
        }

        if ($arquivo['size'] > $tamanhoMaximo) {
            return ['success' => false, 'message' => 'Arquivo muito grande (máx. ' . round($tamanhoMaximo / 1048576, 1) . ' MB).'];
        }

        $mimes = array_unique(array_map(function ($ext) {
            return self::MIMES[$ext];
        }, $tiposPermitidos));
        if (!SecurityHelper::validarMimeArquivo($arquivo['tmp_name'], $mimes)) {
            return ['success' => false, 'message' => 'O conteúdo do arquivo não corresponde ao tipo permitido.'];
        }

        $destino = ROOT_PATH . '/public/uploads/' . trim($pasta, '/');
        if (!is_dir($destino)) {
            mkdir($destino, 0755, true);
        }

        $nome = date('YmdHis') . '_' . bin2hex(random_bytes(8)) . '.' . $extensao;
        if (!move_uploaded_file($arquivo['tmp_name'], $destino . '/' . $nome)) {
            return ['success' => false, 'message' => 'Erro ao salvar o arquivo.'];
        }

        SecurityHelper::logAuditoria('upload_arquivo', Auth::id() ?? 'anonimo', 'Arquivo: ' . $pasta . '/' . $nome);
        return ['success' => true, 'arquivo' => trim($pasta, '/') . '/' . $nome];
    }

    /** Remove um arquivo enviado (caminho relativo a public/uploads). */
    public static function remover(string $caminhoRelativo): bool
    {
        $base = realpath(ROOT_PATH . '/public/uploads');
        $alvo = realpath(ROOT_PATH . '/public/uploads/' . $caminhoRelativo);
        if ($base && $alvo && strpos($alvo, $base . DIRECTORY_SEPARATOR) === 0 && is_file($alvo)) {
            return unlink($alvo);
        }
        return false;
    }
}
