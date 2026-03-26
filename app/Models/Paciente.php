<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Paciente extends Model
{
    // 1. Garanta que esses campos estão aqui
    protected $fillable = [
        'nome', 
        'status',
    ];

    // 2. Informe ao Laravel que 'data_exame' é uma data (isso facilita os cálculos)
    protected $casts = [];

    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class);
    }

    // Atalho para o último agendamento ativo (Para a barra azul)
    public function ultimoAgendamento()
    {
        return $this->hasOne(Agendamento::class)->where('status', 'Agendado')->latestOfMany();
    }

    // AJUSTE NA PROGRESS BAR: Agora ela busca a data da tabela de agendamentos
    public function getProgressoAttribute()
    {
        $agora = Carbon::now();
        $inicio = $this->created_at;
        
        // Buscamos o agendamento ativo diretamente pelo relacionamento
        $exameAtivo = $this->agendamentos()->where('status', 'Agendado')->latest()->first();

        if ($exameAtivo) {
            $fim = Carbon::parse($exameAtivo->data_prevista);
        } else {
            // Prazos padrão se não houver exame
            $prazos = ['Crítico' => 7, 'Observação' => 3, 'Estável' => 1];
            $dias = $prazos[$this->status] ?? 1;
            $fim = $this->created_at->copy()->addDays($dias);
        }

        if ($agora->greaterThan($fim)) return 110;

        $total = $inicio->diffInMinutes($fim);
        $passado = $inicio->diffInMinutes($agora);
        
        return ($total > 0) ? ($passado / $total) * 100 : 0;
    }

}
