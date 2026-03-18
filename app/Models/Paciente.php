<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Paciente extends Model
{
    //
    protected $fillable = ['nome', 'status'];

    public function getProgressoAttribute()
    {
        // Define o prazo em dias baseado no status
        $prazos = [
            'Crítico' => 7,
            'Observação' => 3,
            'Estável' => 1
        ];

        $prazoDias = $prazos[$this->status] ?? 1;
        $dataLimite = $this->created_at->addDays($prazoDias);
        $agora = Carbon::now();

        // Se já recebeu alta, o progresso para ou some
        if ($this->status == 'Alta') return 100;

        $totalMinutos = $this->created_at->diffInMinutes($dataLimite);
        $passadoMinutos = $this->created_at->diffInMinutes($agora, false);

        $porcentagem = ($passadoMinutos / $totalMinutos) * 100;

        return min(max($porcentagem, 0), 110); // Limita entre 0 e 110%
    }

}
