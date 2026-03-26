<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    protected $fillable = [
        'paciente_id', 'medico_id', 'exame_id', 'user_id', 
        'data_prevista', 'status', 'justificativa_cancelamento', 
        'data_cancelamento', 'user_cancelamento_id'
    ];

    protected $casts = [
        'data_prevista' => 'datetime',
        'data_cancelamento' => 'datetime',
    ];

    // Relacionamentos (O coração do sistema)
    public function paciente() { return $this->belongsTo(Paciente::class); }
    public function medico() { return $this->belongsTo(Medico::class); }
    public function exame() { return $this->belongsTo(Exame::class); }
    public function usuario() { return $this->belongsTo(User::class, 'user_id'); }
}
