<?php
// app/Helpers/PasswordHelper.php
// Regra única de senha do sistema (o front usa a mesma em public/js/validar-senha.js).

class PasswordHelper
{
    public const MIN = 8;

    /** @return array ['valid' => bool, 'errors' => string[]] */
    public static function validate(string $password): array
    {
        $errors = [];

        if (mb_strlen($password) < self::MIN) {
            $errors[] = 'Mínimo ' . self::MIN . ' caracteres';
        }
        if (strlen($password) > 72) {
            $errors[] = 'Máximo 72 caracteres';
        }
        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = 'Pelo menos 1 letra maiúscula';
        }
        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = 'Pelo menos 1 letra minúscula';
        }
        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = 'Pelo menos 1 número';
        }
        if (!preg_match('/[^A-Za-z0-9]/', $password)) {
            $errors[] = 'Pelo menos 1 caractere especial';
        }

        return ['valid' => empty($errors), 'errors' => $errors];
    }

    public static function hash(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public static function verify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    /** Senha aleatória forte (gerador criptográfico). */
    public static function generateTemp(int $length = 12): string
    {
        $grupos = ['ABCDEFGHJKLMNPQRSTUVWXYZ', 'abcdefghijkmnopqrstuvwxyz', '23456789', '!@#$%&*?'];
        $todos = implode('', $grupos);
        $senha = [];
        foreach ($grupos as $g) {
            $senha[] = $g[random_int(0, strlen($g) - 1)];
        }
        while (count($senha) < $length) {
            $senha[] = $todos[random_int(0, strlen($todos) - 1)];
        }
        // Embaralha com random_int (str_shuffle não é criptográfico)
        for ($i = count($senha) - 1; $i > 0; $i--) {
            $j = random_int(0, $i);
            [$senha[$i], $senha[$j]] = [$senha[$j], $senha[$i]];
        }
        return implode('', $senha);
    }
}
