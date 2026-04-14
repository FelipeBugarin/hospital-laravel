<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📊 {{ __('Painel de Controle Hospitalar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- SEÇÃO DE CARDS -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                <!-- Card Pacientes -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500 p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 uppercase">Total Pacientes</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $contagem['pacientes'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Card Médicos -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-indigo-500 p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-indigo-100 rounded-full text-indigo-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 uppercase">Equipe Médica</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $contagem['medicos'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Card Críticos (Atenção) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-red-500 p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-red-100 rounded-full text-red-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-red-500 uppercase font-bold italic">🚨 Estado Crítico</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $contagem['criticos'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Card Usuários Pendentes -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-orange-500 p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-orange-100 rounded-full text-orange-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 uppercase">Aguardando Aprovação</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $contagem['pendentes'] }}</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- SEÇÃO DE ACESSO RÁPIDO -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <h3 class="text-lg font-bold text-gray-700 mb-6 uppercase tracking-wider">⚡ Ações Rápidas</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    
                    <a href="{{ route('pacientes.create') }}" class="flex items-center justify-center p-4 bg-green-400 text-white rounded-xl font-bold hover:bg-green-300 transition shadow-lg group">
                        <span>➕ Cadastrar Paciente</span>
                    </a>

                    <a href="{{ route('medicos.create') }}" class="flex items-center justify-center p-4 bg-blue-400 text-white rounded-xl font-bold hover:bg-blue-300 transition shadow-lg">
                        <span>🩺 Novo Médico</span>
                    </a>

                    @if(Auth::id() === 1)
                    <a href="{{ route('usuarios.index') }}" class="flex items-center justify-center p-4 bg-orange-400 text-white rounded-xl font-bold hover:bg-orange-300 transition shadow-lg">
                        <span>👥 Gerenciar Acessos</span>
                    </a>
                    @endif

                </div>
            </div>

            <!-- SEÇÃO DE GRÁFICOS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                <!-- Gráfico de Status -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <h3 class="text-sm font-bold text-gray-500 uppercase mb-4 text-center">Distribuição de Status</h3>
                    <div style="max-height: 300px;" class="flex justify-center">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>

                <!-- Espaço para um segundo gráfico ou Resumo -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <h3 class="text-sm font-bold text-gray-500 uppercase mb-4 text-center">Pacientes por Médico</h3>
                    <div style="max-height: 300px;">
                        <canvas id="medicosChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- TABELA DE PACIENTES RECENTES -->
            <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-bold text-gray-700 uppercase text-sm">🕒 Últimos Pacientes Cadastrados</h3>
                    <a href="{{ route('pacientes.index') }}" class="text-xs text-blue-600 font-bold hover:underline">Ver todos →</a>
                </div>
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 text-gray-400 text-[10px] uppercase font-black">
                        <tr>
                            <th class="py-3 px-6">Paciente</th>
                            <th class="py-3 px-6">Status</th>
                            <th class="py-3 px-6">Data de Cadastro</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @foreach($recentes as $p)
                        <tr class="border-t hover:bg-gray-50 transition">
                            <td class="py-4 px-6 font-bold text-gray-700">{{ $p->nome }}</td>
                            <td class="py-4 px-6">
                                <span class="px-2 py-1 rounded-full text-[10px] font-bold 
                                    {{ $p->status == 'Crítico' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                    {{ $p->status }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-gray-500">{{ $p->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


        @push('scripts')
            <!-- Importando o Chart.js -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <script>
                const ctx = document.getElementById('statusChart').getContext('2d');
                new Chart(ctx, {
                    type: 'doughnut', // Gráfico tipo Rosca
                    data: {
                        labels: ['Estável', 'Observação', 'Crítico', 'Alta'],
                        datasets: [{
                            data: @json($statusData), // Passando os dados do PHP para o JS
                            backgroundColor: ['#10B981', '#F59E0B', '#EF4444', '#3B82F6'],
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'bottom' }
                        }
                    }
                });

                // Gráfico de Barras - Pacientes por Médico
                const ctxMedicos = document.getElementById('medicosChart').getContext('2d');
                new Chart(ctxMedicos, {
                    type: 'bar',
                    data: {
                        labels: @json($labelsMedicos),
                        datasets: [{
                            label: 'Qtd de Pacientes',
                            data: @json($valoresMedicos),
                            backgroundColor: '#6366F1',
                            borderRadius: 5
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: { beginAtZero: true, ticks: { stepSize: 1 } }
                        }
                    }
                });
            </script>
        @endpush

        </div>
    </div>
</x-app-layout>
