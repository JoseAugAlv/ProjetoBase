<?php
// app/Models/Exemplo.php — tabela `exemplo` (modelo para copiar ao criar um model novo)

class Exemplo extends Model
{
    protected $table = 'exemplo';
    protected $primaryKey = 'id_exemplo';

    // Métodos específicos da tabela entram aqui. Ex:
    // public function ativos(): array
    // {
    //     return $this->where(['status' => 'ativo'], 'nome');
    // }
}
