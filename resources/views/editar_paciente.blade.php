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

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Alterar Status:</label>
                <select name="status" id="status-select"
                        class="w-full border-2 border-gray-200 p-3 rounded-lg focus:border-blue-500 focus:outline-none transition">
                    <option value="Estável" {{ $paciente->status == 'Estável' ? 'selected' : '' }}>✅ Estável</option>
                    <option value="Observação" {{ $paciente->status == 'Observação' ? 'selected' : '' }}>⚠️ Observação</option>
                    <option value="Crítico" {{ $paciente->status == 'Crítico' ? 'selected' : '' }}>🚨 Crítico</option>
                    <option value="Alta" {{ $paciente->status == 'Alta' ? 'selected' : '' }}>🏁 Dar Alta</option>
                </select>
                
                <!-- Informativo de Prazo Dinâmico -->
                <div id="prazo-info" class="mt-3 p-3 bg-blue-50 border-l-4 border-blue-500 text-blue-700 text-sm rounded">
                    <p class="font-bold">⏱️ Prazo de Alta Estimado:</p>
                    <span id="prazo-texto"></span>
                </div>
            </div>

            <script>
                const statusSelect = document.getElementById('status-select');
                const prazoTexto = document.getElementById('prazo-texto');
                const prazoInfo = document.getElementById('prazo-info');

                const prazos = {
                    'Estável': '24 horas (1 dia)',
                    'Observação': '72 horas (3 dias)',
                    'Crítico': '168 horas (7 dias)',
                    'Alta': 'Paciente Finalizado (Sem prazo pendente)'
                };

                function atualizarPrazo() {
                    const valor = statusSelect.value;
                    prazoTexto.innerText = prazos[valor] || 'Selecione um status';
                    
                    // Se for Alta, mudamos a cor do informativo para Verde
                    if(valor === 'Alta') {
                        prazoInfo.classList.replace('bg-blue-50', 'bg-green-50');
                        prazoInfo.classList.replace('border-blue-500', 'border-green-500');
                        prazoInfo.classList.replace('text-blue-700', 'text-green-700');
                    } else {
                        prazoInfo.classList.replace('bg-green-50', 'bg-blue-50');
                        prazoInfo.classList.replace('border-green-500', 'border-blue-500');
                        prazoInfo.classList.replace('text-green-700', 'text-blue-700');
                    }
                }

                statusSelect.addEventListener('change', atualizarPrazo);
                atualizarPrazo(); // Roda ao carregar a página
            </script>

            <button type="submit" 
                    class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 shadow-md transition duration-300 transform hover:scale-[1.02]">
                Salvar Cadastro
            </button>
        </form>
    </div>
@endsection
