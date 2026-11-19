<?php
// app/Helpers/RateLimiter.php
// Limita tentativas (login, cadastro, recuperação de senha...) por IP + identificador.
// Os contadores ficam em storage/ratelimit (não na sessão: apagar o cookie não zera o limite).
//
//   if (!RateLimiter::check('login:' . $email, 5, 900)) { ...bloqueado... }
//   RateLimiter::increment('login:' . $email, 900);
//   RateLimiter::reset('login:' . $email);

class RateLimiter
{
    /** true = ainda pode tentar. */
    public static function check(string $chave, int $maxTentativas = 5, int $janelaSegundos = 300): bool
    {
        $dados = self::ler($chave);
        if ($dados === null || time() > $dados['expira']) {
            return true;
        }
        return $dados['tentativas'] < $maxTentativas;
    }

    public static function increment(string $chave, int $janelaSegundos = 300): int
    {
        $arquivo = self::arquivo($chave);
        $fp = fopen($arquivo, 'c+');
        if (!$fp) {
            return 0;
        }
        flock($fp, LOCK_EX);
        $dados = json_decode(stream_get_contents($fp) ?: '', true);
        if (!is_array($dados) || time() > ($dados['expira'] ?? 0)) {
            $dados = ['tentativas' => 0, 'expira' => time() + $janelaSegundos];
        }
        $dados['tentativas']++;
        ftruncate($fp, 0);
        rewind($fp);
        fwrite($fp, json_encode($dados));
        flock($fp, LOCK_UN);
        fclose($fp);

        return $dados['tentativas'];
    }

    /** Segundos até liberar (para mostrar ao usuário). */
    public static function availableIn(string $chave): int
    {
        $dados = self::ler($chave);
        return $dados ? max(0, $dados['expira'] - time()) : 0;
    }

    public static function reset(string $chave): void
    {
        @unlink(self::arquivo($chave));
    }

    private static function ler(string $chave): ?array
    {
        $arquivo = self::arquivo($chave);
        if (!is_file($arquivo)) {
            return null;
        }
        $dados = json_decode((string) @file_get_contents($arquivo), true);
        return is_array($dados) ? $dados : null;
    }

    private static function arquivo(string $chave): string
    {
        $dir = STORAGE_PATH . '/ratelimit';
        if (!is_dir($dir)) {
            mkdir($dir, 0750, true);
        }
        // Limpeza ocasional de contadores vencidos
        if (random_int(1, 200) === 1) {
            foreach (glob($dir . '/*.json') ?: [] as $f) {
                if (filemtime($f) < time() - 86400) {
                    @unlink($f);
                }
            }
        }
        return $dir . '/' . hash('sha256', client_ip() . '|' . mb_strtolower($chave)) . '.json';
    }
}
