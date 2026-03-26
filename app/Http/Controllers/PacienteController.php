<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Agendamento;
use App\Models\Exame;

class PacienteController extends Controller
{

    public function index(Request $request)
    {
        // 1. Contadores Fixos
        $contagem = [
            'total' => Paciente::count(),
            'criticos' => Paciente::where('status', 'Crítico')->count(),
            'observacao' => Paciente::where('status', 'Observação')->count(),
            'alta' => Paciente::where('status', 'Alta')->count(),
        ];

        // 2. Consulta de Pacientes
        $query = Paciente::query();

        // Filtro por Nome
        if ($request->filled('nome')) {
            $query->where('nome', 'like', '%' . $request->nome . '%');
        }

        // Filtro por Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pacientes = $query->with(['agendamentos.exame', 'agendamentos.medico'])->get();

        // 3. Filtro de Prazo (Coleção)
        if ($request->filled('prazo')) {
            $pacientes = $pacientes->filter(function ($p) use ($request) {
                $progresso = $p->progresso;
                if ($request->prazo == 'fora') return $progresso > 100 && $p->status != 'Alta';
                if ($request->prazo == 'atrasado') return $progresso > 50 && $progresso <= 100 && $p->status != 'Alta';
                if ($request->prazo == 'prazo') return $progresso <= 50 && $p->status != 'Alta';
                return true;
            });
        }

        // 4. Buscar médicos para o Modal de Agendamento
        $medicos = \App\Models\Medico::all();
        $exames = \App\Models\Exame::all();

        // 5. Se a requisição for AJAX, retorna apenas um pedaço da view
        if ($request->ajax()) {
            return view('pacientes_tabela', [
                'lista' => $pacientes,
                'medicos' => $medicos,
                'exames' => $exames
            ]);
        }

        $exames = \App\Models\Exame::all();

        return view('pacientes', [
            'lista' => $pacientes, 
            'contagem' => $contagem,
            'medicos' => $medicos,
            'exames' => $exames // <--- Certifique-se de que isso está aqui!
        ]);

        // Se for acesso normal, retorna a página completa
        return view('pacientes', [
            'lista' => $pacientes, 
            'contagem' => $contagem,
            'medicos' => $medicos,
            'exames' => $exames
        ]);

    }

    // Mostra o formulário de cadastro (Antigo cadastro.php)
    public function create()
    {
        return view('cadastro_paciente');
    }

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

    public function agendarExame(Request $request, $id)
    {
        // Criamos o registro na tabela de AGENDAMENTOS
        Agendamento::create([
            'paciente_id' => $id,
            'medico_id' => $request->medico_id,
            'exame_id' => $request->exame_id,
            'user_id' => auth()->id(),
            'data_prevista' => $request->data_exame,
            'status' => 'Agendado'
        ]);

        // 2. ATUALIZAMOS O STATUS DO PACIENTE (O passo que faltava!)
        $paciente = Paciente::findOrFail($id);
        $paciente->update(['status' => 'Exame Agendado']);

        return back()->with('sucesso', 'Exame agendado no histórico do paciente!');
    }

    public function cancelarAgendamento(Request $request, $id)
        {
            // 1. Buscamos o agendamento específico na tabela nova
            $agendamento = Agendamento::findOrFail($id);
            
            // 2. Atualizamos o status do agendamento e gravamos a auditoria
            $agendamento->update([
                'status' => 'Cancelado',
                'justificativa_cancelamento' => $request->justificativa,
                'data_cancelamento' => now(),
                'user_cancelamento_id' => auth()->id(),
            ]);

            // 3. Devolvemos o Paciente para um status comum (Estável, Crítico, etc)
            $paciente = Paciente::findOrFail($agendamento->paciente_id);
            $paciente->update([
                'status' => $request->status // O novo status escolhido no modal
            ]);

            return back()->with('sucesso', 'Exame cancelado e registrado no histórico!');
        }

}
