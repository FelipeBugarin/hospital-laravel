<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;

class PacienteController extends Controller
{
    // Lista todos os pacientes (Antigo lista.php)
    public function index()
    {
        $pacientes = Paciente::all();
        return view('pacientes', ['lista' => $pacientes]);
    }

    // Mostra o formulário de cadastro (Antigo cadastro.php)
    public function create()
    {
        return view('cadastro_paciente');
    }

    // Salva o novo paciente no banco (Antigo processar_cadastro.php)
    public function store(Request $request)
    {
        Paciente::create([
            'nome' => $request->nome,
            'status' => $request->status,
        ]);

        return redirect('/pacientes');
    }

    // Deleta um paciente
    public function destroy($id)
    {
        $paciente = Paciente::findOrFail($id);
        $paciente->delete();

        return redirect('/pacientes');
    }

    // Mostra a tela de edição de um paciente
    public function edit($id)
    {
        $paciente = Paciente::findOrFail($id);
        return view('editar_paciente', ['paciente' => $paciente]);
    }

    // Atualiza os dados de um paciente
    public function update(Request $request, $id)
    {
        $paciente = Paciente::findOrFail($id);
        $paciente->update([
            'nome' => $request->nome,
            'status' => $request->status,
        ]);

        return redirect('/pacientes');
    }

}
