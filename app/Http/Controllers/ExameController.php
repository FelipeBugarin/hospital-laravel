<?php

namespace App\Http\Controllers;

use App\Models\Exame;
use Illuminate\Http\Request;

class ExameController extends Controller
{
    public function index() {
        return view('exames.index', ['exames' => Exame::all()]);
    }

    public function store(Request $request) {
        $request->validate(['nome' => 'required|min:3']);
        Exame::create($request->all());
        return back()->with('sucesso', 'Tipo de exame cadastrado!');
    }
}
