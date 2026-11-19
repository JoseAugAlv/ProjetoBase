<?php
// app/Models/Notificacao.php — tabela `notificacao`

class Notificacao extends Model
{
    protected $table = 'notificacao';
    protected $primaryKey = 'id_notificacao';

    /** Cria uma notificação para um usuário. */
    public function criar(int $idUsuario, string $titulo, string $mensagem = '', string $tipo = 'info', ?string $tabelaOrigem = null, ?int $registroId = null): int
    {
        return $this->insert([
            'id_usuario' => $idUsuario,
            'tipo' => $tipo,
            'titulo' => $titulo,
            'mensagem' => $mensagem,
            'tabela_origem' => $tabelaOrigem,
            'registro_id' => $registroId,
        ]);
    }

    public function getByUsuario(int $idUsuario, int $limite = 100): array
    {
        return $this->where(['id_usuario' => $idUsuario], 'data_criacao DESC', $limite);
    }

    public function getNaoLidas(int $idUsuario): array
    {
        return $this->where(['id_usuario' => $idUsuario, 'lida' => 0], 'data_criacao DESC');
    }

    public function contarNaoLidas(int $idUsuario): int
    {
        return $this->count(['id_usuario' => $idUsuario, 'lida' => 0]);
    }

    /** Só marca se a notificação pertencer ao usuário (evita mexer na de outra pessoa). */
    public function marcarComoLida(int $idNotificacao, int $idUsuario): bool
    {
        return $this->execute(
            "UPDATE notificacao SET lida = TRUE, data_leitura = NOW() WHERE id_notificacao = ? AND id_usuario = ?",
            [$idNotificacao, $idUsuario]
        ) > 0;
    }

    public function marcarTodasComoLidas(int $idUsuario): int
    {
        return $this->execute(
            "UPDATE notificacao SET lida = TRUE, data_leitura = NOW() WHERE id_usuario = ? AND lida = FALSE",
            [$idUsuario]
        );
    }
}
