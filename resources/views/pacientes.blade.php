@extends('layouts.app')

@section('titulo', 'Lista de Pacientes')

@section('conteudo')
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <!-- CABEÇALHO COM BOTÃO -->
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h1 class="text-2xl font-bold text-blue-600">🏥 Painel do Hospital - Pacientes</h1>
            <a href="/pacientes/novo" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 font-bold transition shadow-sm">
                + Novo Paciente
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <!-- Card Total -->
            <div class="bg-white p-4 rounded-xl shadow-sm border-l-4 border-gray-400">
                <p class="text-gray-500 text-xs font-bold uppercase">Total Pacientes</p>
                <p class="text-2xl font-black text-gray-800">{{ $contagem['total'] }}</p>
            </div>
            
            <!-- Card Críticos -->
            <div class="bg-white p-4 rounded-xl shadow-sm border-l-4 border-red-500">
                <p class="text-red-500 text-xs font-bold uppercase">🚨 Críticos</p>
                <p class="text-2xl font-black text-gray-800">{{ $contagem['criticos'] }}</p>
            </div>

            <!-- Card Observação -->
            <div class="bg-white p-4 rounded-xl shadow-sm border-l-4 border-orange-400">
                <p class="text-orange-400 text-xs font-bold uppercase">⚠️ Observação</p>
                <p class="text-2xl font-black text-gray-800">{{ $contagem['observacao'] }}</p>
            </div>

            <!-- Card Alta -->
            <div class="bg-white p-4 rounded-xl shadow-sm border-l-4 border-green-500">
                <p class="text-green-500 text-xs font-bold uppercase">✅ Altas Hoje</p>
                <p class="text-2xl font-black text-gray-800">{{ $contagem['alta'] }}</p>
            </div>
        </div>

        <form id="filtro-form" action="/pacientes" method="GET" class="bg-gray-50 p-4 rounded-lg mb-6 flex flex-wrap gap-4 items-end border">
            <!-- Busca por Nome -->
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-bold text-gray-600 mb-1 uppercase">Nome do Paciente</label>
                <input type="text" name="nome" value="{{ request('nome') }}" placeholder="Pesquisar..." 
                    class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <!-- Filtro por Status -->
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-1 uppercase">Status</label>
                <select name="status" class="border rounded-lg p-2 text-sm outline-none">
                    <option value="">Todos</option>
                    <option value="Estável" {{ request('status') == 'Estável' ? 'selected' : '' }}>Estável</option>
                    <option value="Observação" {{ request('status') == 'Observação' ? 'selected' : '' }}>Observação</option>
                    <option value="Crítico" {{ request('status') == 'Crítico' ? 'selected' : '' }}>Crítico</option>
                    <option value="Alta" {{ request('status') == 'Alta' ? 'selected' : '' }}>Alta</option>
                </select>
            </div>

            <!-- Filtro por Prazo -->
            <div>
                <label class="block text-xs font-bold text-gray-600 mb-1 uppercase">Prazo (SLA)</label>
                <select name="prazo" class="border rounded-lg p-2 text-sm outline-none">
                    <option value="">Todos</option>
                    <option value="prazo" {{ request('prazo') == 'prazo' ? 'selected' : '' }}>No Prazo</option>
                    <option value="atrasado" {{ request('prazo') == 'atrasado' ? 'selected' : '' }}>Atrasado (>50%)</option>
                    <option value="fora" {{ request('prazo') == 'fora' ? 'selected' : '' }}>Fora do Prazo</option>
                </select>
            </div>

            <!-- Botões -->
            <div class="flex gap-2">
                <!-- <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-blue-700 transition">
                    Filtrar
                </button> -->
                <a href="/pacientes" class="bg-gray-200 text-gray-600 px-4 py-2 rounded-lg font-bold hover:bg-gray-300 transition text-center">
                    Limpar
                </a>
            </div>
        </form>


        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-gray-600 uppercase text-sm leading-normal border-b">
                    <th class="py-3 px-2">ID</th>
                    <th class="py-3 px-2">Nome</th>
                    <th class="py-3 px-2">Status</th>
                    <th class="py-3 px-2 text-center">Ações</th>
                </tr>
            </thead>
            <tbody id="tabela-pacientes">
                @include('pacientes_tabela')
            </tbody>
        </table>
    </div>

    <script>
    const form = document.getElementById('filtro-form');
    const tabela = document.getElementById('tabela-pacientes');

    // Função que busca os dados no servidor
    function buscarDados() {
        const formData = new FormData(form);
        const params = new URLSearchParams(formData).toString();

        fetch(`/pacientes?${params}`, {
            headers: { "X-Requested-With": "XMLHttpRequest" }
        })
        .then(response => response.text())
        .then(html => {
            tabela.innerHTML = html;
        });
    }

    // Monitora digitação no nome e mudanças nos selects
    form.addEventListener('input', buscarDados);
    
    // Evita que o Enter recarregue a página
    form.addEventListener('submit', (e) => e.preventDefault());
</script>

@endsection
