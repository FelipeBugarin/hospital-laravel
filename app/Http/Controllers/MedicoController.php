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
}
