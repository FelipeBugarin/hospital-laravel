<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agendamento;

class PainelController extends Controller
{
    public function index()
    {
        // Pega os exames agendados para hoje, ordenados por hora
        $agendamentos = Agendamento::with(['paciente', 'medico', 'exame'])
            ->where('status', 'Agendado')
            ->whereDate('data_prevista', now()->today())
            ->orderBy('data_prevista', 'asc')
            ->get();

        return view('painel', compact('agendamentos'));
    }
}
