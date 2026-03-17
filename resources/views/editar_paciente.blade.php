@extends('layouts.app')

@section('titulo', 'Cadastrar Novo Paciente')

@section('conteudo')
    <div class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow-lg mt-10">
        <!-- TÍTULO E BOTÃO VOLTAR -->
        <div class="flex justify-between items-center mb-8 border-b pb-4">
            <h1 class="text-2xl font-bold text-blue-600 font-sans">🩺 Novo Cadastro</h1>
            <a href="/pacientes" class="text-gray-500 hover:text-gray-700 text-sm font-semibold transition">
                ← Voltar para a lista
            </a>
        </div>
        
        <form action="/pacientes/{{ $paciente->id }}" method="POST" class="space-y-6">
            @csrf <!-- Proteção obrigatória do Laravel -->
            @method('PUT') <!-- O Laravel precisa disso para entender que é um PUT -->
            <div>
                <label class="block text-gray-700 font-bold mb-2">Nome Completo do Paciente:</label>
                <input type="text" name="nome" 
                       class="w-full border-2 border-gray-200 p-3 rounded-lg focus:border-blue-500 focus:outline-none transition" 
                       placeholder="Ex: João da Silva" value="{{ $paciente->nome }}" required>
            </div>

            <div>
                <label class="block text-gray-700 font-bold mb-2">Status Inicial:</label>
                <select name="status" 
                        class="w-full border-2 border-gray-200 p-3 rounded-lg focus:border-blue-500 focus:outline-none transition">
                    <option value="Estável" {{ $paciente->status == 'Estável' ? 'selected' : '' }}>✅ Estável</option>
                    <option value="Observação" {{ $paciente->status == 'Observação' ? 'selected' : '' }}>⚠️ Observação</option>
                    <option value="Crítico" {{ $paciente->status == 'Crítico' ? 'selected' : '' }}>🚨 Crítico</option>
                </select>
            </div>

            <button type="submit" 
                    class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 shadow-md transition duration-300 transform hover:scale-[1.02]">
                Salvar Cadastro
            </button>
        </form>
    </div>
@endsection
