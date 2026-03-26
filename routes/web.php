<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\ExameController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // SUAS ROTAS DO HOSPITAL (Devolvendo elas para o sistema)
    Route::get('/pacientes', [PacienteController::class, 'index'])->name('pacientes.index');
    Route::get('/pacientes/novo', [PacienteController::class, 'create'])->name('pacientes.create');
    Route::post('/pacientes/salvar', [PacienteController::class, 'store'])->name('pacientes.store');
    Route::delete('/pacientes/{id}', [PacienteController::class, 'destroy'])->name('pacientes.destroy');
    Route::get('/pacientes/{id}/editar', [PacienteController::class, 'edit'])->name('pacientes.edit');
    Route::put('/pacientes/{id}', [PacienteController::class, 'update'])->name('pacientes.update');
    Route::patch('/pacientes/{id}/status', [PacienteController::class, 'updateStatus'])->name('pacientes.updateStatus');
    Route::patch('/pacientes/{id}/agendar', [PacienteController::class, 'agendarExame'])->name('pacientes.agendar');
    // Rotas de Médicos
    Route::get('/medicos', [MedicoController::class, 'index'])->name('medicos.index');
    Route::get('/medicos/novo', [MedicoController::class, 'create'])->name('medicos.create');
    Route::post('/medicos/salvar', [MedicoController::class, 'store'])->name('medicos.store');
    //Rotas de Exames
    Route::get('/exames', [ExameController::class, 'index'])->name('exames.index');
    Route::post('/exames/salvar', [ExameController::class, 'store'])->name('exames.store');
    //Cancelar Exame
    Route::patch('/agendamentos/{id}/cancelar', [PacienteController::class, 'cancelarAgendamento'])->name('agendamentos.cancelar');

});

require __DIR__.'/auth.php';
