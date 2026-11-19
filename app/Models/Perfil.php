<?php
// app/Models/Perfil.php — tabela `perfil` + regras de hierarquia de perfis.
// Use as constantes nas rotas: [Perfil::MASTER, Perfil::ADMIN]

class Perfil extends Model
{
    public const MASTER = 1;
    public const ADMIN = 2;
    public const OPERADOR = 3;
    public const USUARIO = 4;

    protected $table = 'perfil';
    protected $primaryKey = 'id_perfil';

    public static function getNome(int $id): string
    {
        return [
            self::MASTER => 'Master',
            self::ADMIN => 'Admin',
            self::OPERADOR => 'Operador',
            self::USUARIO => 'Usuario',
        ][$id] ?? 'Desconhecido';
    }

    /** Quanto maior, mais poder. */
    public static function getHierarquia(): array
    {
        return [self::MASTER => 4, self::ADMIN => 3, self::OPERADOR => 2, self::USUARIO => 1];
    }

    public static function isHigherOrEqual(int $role, int $required): bool
    {
        $h = self::getHierarquia();
        return ($h[$role] ?? 0) >= ($h[$required] ?? 0);
    }

    /**
     * Quem pode editar/desativar/trocar o perfil de quem:
     * Master gerencia todos; Admin só Operador e Usuario; os demais ninguém.
     */
    public static function podeGerenciar(int $ator, int $alvo): bool
    {
        if ($ator === self::MASTER) {
            return true;
        }
        if ($ator === self::ADMIN) {
            return in_array($alvo, [self::OPERADOR, self::USUARIO], true);
        }
        return false;
    }

    /** Perfis que o ator pode atribuir a alguém. */
    public static function atribuiveis(int $ator): array
    {
        return array_values(array_filter(
            [self::MASTER, self::ADMIN, self::OPERADOR, self::USUARIO],
            function ($p) use ($ator) {
                return self::podeGerenciar($ator, $p);
            }
        ));
    }
}
