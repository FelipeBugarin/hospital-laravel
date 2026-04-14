<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Medico;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Buscando os totais para os cards
        $contagem = [
            'pacientes' => Paciente::count(),
            'medicos'   => Medico::count(),
            'pendentes' => User::where('is_approved', false)->count(),
            'criticos'  => Paciente::where('status', 'Crítico')->count(),
        ];

        // Dados para o Gráfico de Status
        $statusData = [
            Paciente::where('status', 'Estável')->count(),
            Paciente::where('status', 'Observação')->count(),
            Paciente::where('status', 'Crítico')->count(),
            Paciente::where('status', 'Alta')->count(),
        ];

        // Busca médicos e conta quantos pacientes cada um tem
        // O 'withCount' cria automaticamente uma variável 'pacientes_count'
        $medicosDados = Medico::withCount('pacientes')->get();

        $labelsMedicos = $medicosDados->pluck('nome'); // Pega só os nomes
        $valoresMedicos = $medicosDados->pluck('pacientes_count'); // Pega só as contagens
        $recentes = Paciente::latest()->take(5)->get();

        return view('dashboard', compact('contagem', 'statusData', 'labelsMedicos', 'valoresMedicos', 'recentes'));
    }
}
