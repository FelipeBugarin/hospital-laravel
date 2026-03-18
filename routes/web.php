<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacienteController;

// Página inicial (opcional, redireciona para a lista)
Route::get('/', function () {
    return redirect('/pacientes');
});

// Rotas do Hospital
Route::get('/pacientes', [PacienteController::class, 'index']);
Route::get('/pacientes/novo', [PacienteController::class, 'create']);
Route::post('/pacientes/salvar', [PacienteController::class, 'store']);
Route::delete('/pacientes/{id}', [PacienteController::class, 'destroy']);
Route::get('/pacientes/{id}/editar', [PacienteController::class, 'edit']);
Route::put('/pacientes/{id}', [PacienteController::class, 'update']);
Route::patch('/pacientes/{id}/status', [PacienteController::class, 'updateStatus']);
