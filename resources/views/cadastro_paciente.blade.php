<x-app-layout>
    <!-- Isso aqui é o título que aparece na barra branca do topo -->
    {{-- <x-slot name="header">
        <h1 class="text-2xl font-bold text-blue-600 font-sans">🩺 Novo Cadastro</h1>
            <a href="/pacientes" class="text-gray-500 hover:text-gray-700 text-sm font-semibold transition">
                ← Voltar para a lista
            </a>
    </x-slot> --}}

    <div class="max-w-xl mx-auto bg-white p-8 rounded-lg shadow-lg mt-10">
        <!-- TÍTULO E BOTÃO VOLTAR -->
        <div class="flex justify-between items-center mb-8 border-b pb-4">
            <h1 class="text-2xl font-bold text-blue-600 font-sans">🩺 Novo Cadastro</h1>
            <a href="/pacientes" class="text-gray-500 hover:text-gray-700 text-sm font-semibold transition">
                ← Voltar para a lista
            </a>
        </div>
        
        <form action="/pacientes/salvar" method="POST" class="space-y-6">
            @csrf <!-- Proteção obrigatória do Laravel -->
            
            <div>
                <label class="block text-gray-700 font-bold mb-2">Nome Completo do Paciente:</label>
                <input type="text" name="nome" 
                       class="w-full border-2 border-gray-200 p-3 rounded-lg focus:border-blue-500 focus:outline-none transition" 
                       placeholder="Ex: João da Silva" required>
                       @error('nome')
                            <span class="text-red-500 text-sm font-bold">{{ $message }}</span>
                        @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Status Inicial:</label>
                <select name="status" id="status-select"
                        class="w-full border-2 border-gray-200 p-3 rounded-lg focus:border-blue-500 focus:outline-none transition">
                    <option value="Estável">✅ Estável</option>
                    <option value="Observação">⚠️ Observação</option>
                    <option value="Crítico">🚨 Crítico</option>
                </select>
                
                <!-- Informativo de Prazo Dinâmico -->
                <div id="prazo-info" class="mt-3 p-3 bg-blue-50 border-l-4 border-blue-500 text-blue-700 text-sm rounded">
                    <p class="font-bold">⏱️ Prazo de Alta Estimado:</p>
                    <span id="prazo-texto">24 horas (1 dia)</span>
                </div>
            </div>

            <!-- Script para mudar o texto dinamicamente -->
            <script>
                const statusSelect = document.getElementById('status-select');
                const prazoTexto = document.getElementById('prazo-texto');

                const prazos = {
                    'Estável': '24 horas (1 dia)',
                    'Observação': '72 horas (3 dias)',
                    'Crítico': '168 horas (7 dias)'
                };

                statusSelect.addEventListener('change', function() {
                    prazoTexto.innerText = prazos[this.value] || 'Selecione um status';
                });
            </script>

            <button type="submit" 
                    class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 shadow-md transition duration-300 transform hover:scale-[1.02]">
                Salvar Cadastro
            </button>
        </form>
    </div>
</x-app-layout>
