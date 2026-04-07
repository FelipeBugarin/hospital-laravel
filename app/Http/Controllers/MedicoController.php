<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use Illuminate\Http\Request;

class MedicoController extends Controller
{
    public function index() {
        $medicos = Medico::all();
        return view('medicos.index', ['medicos' => $medicos]);
    }

    public function create() {
        return view('medicos.create');
    }

    public function store(Request $request) {
        $request->validate([
            'nome' => 'required|min:3',
            'crm' => 'required|unique:medicos',
            'especialidade' => 'required'
        ]);

        Medico::create($request->all());
        return redirect()->route('medicos.index')->with('sucesso', 'Médico cadastrado com sucesso!');
    }

    public function destroy($id)
        {
            $medico = \App\Models\Medico::findOrFail($id);
            $medico->delete();

            return redirect()->route('medicos.index')->with('sucesso', 'Médico removido com sucesso!');
        }

    public function edit($id)
        {
            $medico = \App\Models\Medico::findOrFail($id);
            return view('medicos.edit', compact('medico'));
        }

    public function update(Request $request, $id)
        {
            $request->validate([
                'nome' => 'required|string|max:255',
                'crm' => 'required|string|max:20|unique:medicos,crm,' . $id,
                'especialidade' => 'required|string|max:100',
            ]);

            $medico = \App\Models\Medico::findOrFail($id);
            $medico->update($request->all());

            return redirect()->route('medicos.index')->with('sucesso', 'Cadastro do médico atualizado!');
        }

}
