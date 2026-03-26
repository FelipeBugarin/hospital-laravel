<x-app-layout>
    <!-- Isso aqui é o título que aparece na barra branca do topo -->
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                🏥 Painel do Hospital - Pacientes
            </h2>
            <a href="/pacientes/novo" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 font-bold transition shadow-sm">
                + Novo Paciente
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg mt-10">
        <!-- CABEÇALHO COM BOTÃO -->
        {{-- <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h1 class="text-2xl font-bold text-blue-600">🏥 Painel do Hospital - Pacientes</h1>
            <a href="/pacientes/novo" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 font-bold transition shadow-sm">
                + Novo Paciente
            </a>
        </div> --}}
        
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
                    <th class="py-3 px-2 w-1/4">Nome</th> <!-- Nome ganha espaço -->
                    <th class="py-3 px-2 w-1/3">Status</th> <!-- Status ganha bastante espaço -->
                    <th class="py-3 px-2 w-48">Prazo</th> <!-- Prazo fica com largura fixa menor -->
                    <th class="py-3 px-2 text-center">Ações</th>
                </tr>
            </thead>
            <tbody id="tabela-pacientes">
                @include('pacientes_tabela')
            </tbody>
        </table>
    </div>

    <!-- MODAL DE AGENDAMENTO -->
    <x-modal name="modal-agendamento" focusable>
        <form action="" id="form-agendar" method="POST" class="p-6">
            @csrf
            @method('PATCH')
            
            <h2 class="text-lg font-medium text-gray-900">
                Agendar Exame para: <span id="nome_paciente_modal" class="text-blue-600 font-bold"></span>
            </h2>

            <div class="mt-6 space-y-4">
                <div>
                    <label class="block font-medium text-sm text-gray-700">Tipo de Exame</label>
                    <select name="exame_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="">Selecione o Exame...</option>
                        @foreach($exames as $e)
                            <option value="{{ $e->id }}">{{ $e->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block font-medium text-sm text-gray-700">Data e Hora do Exame</label>
                    <input name="data_exame" type="datetime-local" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full" required />
                </div>

                <div>
                    <label class="block font-medium text-sm text-gray-700">Médico Responsável</label>
                    <select name="medico_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach($medicos as $m)
                            <option value="{{ $m->id }}">{{ $m->nome }} ({{ $m->especialidade }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 bg-gray-200 rounded-md mr-2">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Confirmar Agendamento</button>
            </div>
        </form>
    </x-modal>

    <x-modal name="modal-cancelamento" focusable>
        <form action="" id="form-cancelar" method="POST" class="p-6">
            @csrf @method('PATCH')
            <input type="hidden" name="cancelar_exame" value="true">

            <h2 class="text-lg font-medium text-red-600">
                🚫 Cancelar Exame: <span id="nome_cancelamento_modal" class="font-bold text-gray-900"></span>
            </h2>

            <div class="mt-6 space-y-4">
                <div>
                    <x-input-label value="Justificativa do Cancelamento" />
                    <textarea name="justificativa" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500" placeholder="Descreva o motivo..."></textarea>
                </div>

                <div>
                    <x-input-label value="Novo Status do Paciente" />
                    <select name="status" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="Estável">Estável</option>
                        <option value="Observação">Observação</option>
                        <option value="Crítico">Crítico</option>
                        <option value="Agendar">🗓️ Agendar Nova Data</option>
                    </select>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">Voltar</x-secondary-button>
                <x-primary-button class="ml-3 bg-red-600 hover:bg-red-700" onclick="submeterCancelamento()">Confirmar Cancelamento</x-primary-button>
            </div>
        </form>
    </x-modal>

    <script>
        // Função para interceptar o select e abrir o modal de Agendar Exame
        function verificarStatus(select, id, nome) {
            if (select.value === 'Agendar') {
                // Preenche o nome no modal
                document.getElementById('nome_paciente_modal').innerText = nome;
                
                // Configura a rota do form dinamicamente
                const formAgendar = document.getElementById('form-agendar');
                formAgendar.action = `/pacientes/${id}/agendar`;
                
                // Dispara o evento do Alpine.js (Breeze) para abrir o modal
                window.dispatchEvent(new CustomEvent('open-modal', { detail: 'modal-agendamento' }));
                
                // Reseta o select para o valor anterior (pra não enviar o form de status por erro)
                select.value = ""; 
            } else {
                // Se não for agendar, envia o formulário de troca de status normal
                select.form.submit();
            }
        }

        //Modal de Cancelamento de Exame
        function abrirModalCancelamento(pacienteId, nome, agendamentoId) {
            document.getElementById('nome_cancelamento_modal').innerText = nome;
            const form = document.getElementById('form-cancelar');
            
            // Agora a rota aponta para o ID do AGENDAMENTO
            form.action = `/agendamentos/${agendamentoId}/cancelar`;
            
            window.dispatchEvent(new CustomEvent('open-modal', { detail: 'modal-cancelamento' }));
        }

        function submeterCancelamento() {
            document.getElementById('form-cancelar').submit();
        }

        //Prontuario do Paciente
        function verProntuario(paciente) {
            // Montamos o HTML do histórico dinamicamente
            let historicoHtml = '';
            
            paciente.agendamentos.forEach(ag => {
                const corStatus = ag.status === 'Agendado' ? 'text-blue-600' : 'text-red-600';
                historicoHtml += `
                    <div class="border-l-2 border-gray-200 pl-4 mb-4 relative">
                        <div class="absolute -left-[5px] top-1 w-2 h-2 bg-gray-400 rounded-full"></div>
                        <p class="text-[10px] font-bold ${corStatus} uppercase">${ag.status}</p>
                        <p class="text-sm font-bold text-gray-800">${ag.exame.nome}</p>
                        <p class="text-[10px] text-gray-500 font-medium italic">
                            👨‍⚕️ Dr(a). ${ag.medico.nome} | 📅 Data: ${new Date(ag.data_prevista).toLocaleString('pt-BR', { 
                                day: '2-digit', 
                                month: '2-digit', 
                                year: 'numeric', 
                                hour: '2-digit', 
                                minute: '2-digit',
                                timeZone: 'UTC'
                            })}
                        </p>
                        ${ag.justificativa_cancelamento ? `<p class="text-xs italic text-red-400 mt-1">"${ag.justificativa_cancelamento}"</p>` : ''}
                    </div>
                `;
            });

            Swal.fire({
                title: `📄 Prontuário: ${paciente.nome}`,
                html: `<div class="text-left">${historicoHtml || 'Sem histórico.'}</div>`,
                confirmButtonText: 'Fechar'
            });
        }

    </script>

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

</x-app-layout>
