<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;

class PacienteController extends Controller
{

    public function index(Request $request)
    {
        // Contadores Fixos (Sempre mostram o total real do hospital)
        $contagem = [
            'total' => Paciente::count(),
            'criticos' => Paciente::where('status', 'Crítico')->count(),
            'observacao' => Paciente::where('status', 'Observação')->count(),
            'alta' => Paciente::where('status', 'Alta')->count(),
        ];

        // Iniciamos a consulta sem executar ainda
        $query = Paciente::query();

        // Filtro por Nome
        if ($request->filled('nome')) {
            $query->where('nome', 'like', '%' . $request->nome . '%');
        }

        // Filtro por Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pacientes = $query->get();

        // Filtro por Prazo (Feito via Coleção, pois a lógica está no Model)
        if ($request->filled('prazo')) {
            $pacientes = $pacientes->filter(function ($p) use ($request) {
                $progresso = $p->progresso;
                if ($request->prazo == 'fora') return $progresso > 100 && $p->status != 'Alta';
                if ($request->prazo == 'atrasado') return $progresso > 50 && $progresso <= 100 && $p->status != 'Alta';
                if ($request->prazo == 'prazo') return $progresso <= 50 && $p->status != 'Alta';
                return true;
            });
        }

        // Se a requisição for AJAX, retorna apenas um pedaço da view
        if ($request->ajax()) {
            return view('pacientes_tabela', ['lista' => $pacientes]);
        }

        return view('pacientes', ['lista' => $pacientes, 'contagem' => $contagem]);
    }
    // Mostra o formulário de cadastro (Antigo cadastro.php)
    public function create()
    {
        return view('cadastro_paciente');
    }

    // Salva o novo paciente no banco (Antigo processar_cadastro.php)
    // Salva o novo paciente (Versão Única e Validada)
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|min:3',
            'status' => 'required',
        ], [
            'nome.required' => 'O nome do paciente é obrigatório.',
            'nome.min' => 'O nome deve ter pelo menos 3 caracteres.',
        ]);

        Paciente::create($request->all());

        return redirect('/pacientes')->with('sucesso', 'Paciente cadastrado com sucesso!');
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
    // Atualiza os dados (Também com validação!)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|min:3',
            'status' => 'required',
        ], [
            'nome.required' => 'O nome é obrigatório ao editar.',
        ]);

        $paciente = Paciente::findOrFail($id);
        $paciente->update($request->all());

        return redirect('/pacientes')->with('sucesso', 'Paciente atualizado com sucesso!');
    }

    public function updateStatus(Request $request, $id)
    {
        $paciente = Paciente::findOrFail($id);
        $paciente->update(['status' => $request->status]);

        return back()->with('sucesso', 'Status atualizado!');
    }

}
