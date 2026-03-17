<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Paciente;

/*

|--------------------------------------------------------------------------
| ARQUIVO DE ROTAS - O MAESTRO DO SISTEMA
|--------------------------------------------------------------------------
*/

// 1. ROTA PARA MOSTRAR A LISTA (O seu antigo "lista.php")
Route::get('/pacientes', function () {
    $pacientes = Paciente::all(); // Busca no banco via Model
    return view('pacientes', ['lista' => $pacientes]);
});

// 2. ROTA PARA MOSTRAR O FORMULÁRIO (O seu antigo "cadastro.php")
Route::get('/pacientes/novo', function () {
    return view('cadastro_paciente');
});

// 3. ROTA PARA PROCESSAR O SALVAMENTO (O seu antigo "processar_cadastro.php")
Route::post('/pacientes/salvar', function (Request $request) {
    // No PHP puro você usaria $_POST['nome']. No Laravel usamos $request->nome.
    Paciente::create([
        'nome' => $request->nome,
        'status' => $request->status,
    ]);

    // Após salvar, ele redireciona para a lista
    return redirect('/pacientes');
});
