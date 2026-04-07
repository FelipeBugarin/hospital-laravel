<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    // Lista usuários pendentes e aprovados
    public function index()
    {
        $usuariosPendentes = User::where('is_approved', false)->get();
        $usuariosAprovados = User::where('is_approved', true)->get();

        return view('admin.usuarios', compact('usuariosPendentes', 'usuariosAprovados'));
    }

    // Aprova o usuário
    public function aprovar($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_approved' => true]);

        return redirect()->back()->with('sucesso', "O usuário {$user->name} foi aprovado!");
    }
}
