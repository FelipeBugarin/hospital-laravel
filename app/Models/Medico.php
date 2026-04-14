<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough; // Importe isso

class Medico extends Model
{
    protected $fillable = ['nome', 'especialidade', 'crm'];

    // Definindo o relacionamento com Paciente
    public function pacientes(): HasManyThrough
    {
        // O médico tem muitos pacientes ATRAVÉS da tabela de agendamentos
        return $this->hasManyThrough(
                Paciente::class, 
                Agendamento::class, 
                'medico_id', // Chave estrangeira em Agendamento
                'id',        // Chave estrangeira em Paciente (id do paciente)
                'id',        // Chave local em Medico
                'paciente_id' // Chave local em Agendamento que liga ao Paciente
            );
    }

}
