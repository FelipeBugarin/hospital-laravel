
                @foreach($lista as $p)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-4 px-2">
                        <!-- CORREÇÃO 1: Passamos o objeto JSON completo para o JavaScript processar o histórico -->
                        <button type="button" 
                                onclick="verProntuario({{ $p->toJson() }})"
                                class="group text-blue-600 font-bold hover:text-blue-800 text-left transition flex items-center gap-1">
                            <span>{{ $p->nome }}</span>
                            <svg class="w-3 h-3 opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </button>
                    </td>
                    
                    <!-- Alteração de Status Direta -->
                    <td class="py-4 px-2">
                        <!-- CORREÇÃO 2: Buscamos o médico através do ÚLTIMO agendamento ativo -->
                        @php $ultimoExame = $p->agendamentos->where('status', 'Agendado')->first(); @endphp
                        
                        @if($p->status == 'Exame Agendado' && $ultimoExame)
                            <div class="flex flex-col bg-blue-50 border border-blue-200 rounded p-2 shadow-sm">
                                <span class="text-[10px] text-blue-700 font-black uppercase italic">🗓️ Exame Agendado</span>
                                <div class="text-[11px] text-blue-600 font-bold mt-1">
                                    <!-- Acessamos o nome do médico via relacionamento do agendamento -->
                                    👨‍⚕️ Dr. {{ $ultimoExame->medico->nome ?? 'Não definido' }}
                                </div>
                            </div>
                        @else
                            <form action="/pacientes/{{ $p->id }}/status" method="POST">
                                @csrf @method('PATCH')
                                <select name="status" onchange="verificarStatus(this, '{{ $p->id }}', '{{ $p->nome }}')" 
                                        class="text-xs border border-gray-300 rounded p-2 w-full bg-white shadow-sm focus:ring-2 focus:ring-blue-500">
                                    <option value="Estável" {{ $p->status == 'Estável' ? 'selected' : '' }}>Estável</option>
                                    <option value="Observação" {{ $p->status == 'Observação' ? 'selected' : '' }}>Observação</option>
                                    <option value="Crítico" {{ $p->status == 'Crítico' ? 'selected' : '' }}>Crítico</option>
                                    <option value="Alta" {{ $p->status == 'Alta' ? 'selected' : '' }}>Alta</option>
                                    <option value="Agendar">➕ Agendar Novo Exame</option>
                                </select>
                            </form>
                        @endif
                    </td>

                    <!-- Progress Bar de Prazo -->
                    <td class="py-4 px-2 w-48">
                        @if($p->status == 'Alta')
                            <div class="flex items-center gap-2">
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold border border-green-200">
                                    ✅ Recebeu Alta
                                </span>
                            </div>
                        @else
                            @php
                                $progresso = $p->progresso;
                                $cor = 'bg-green-500';
                                $texto = 'No Prazo';

                                // CORREÇÃO 3: Usamos a variável $ultimoExame que definimos acima
                                if($ultimoExame) {
                                    $cor = 'bg-blue-600';
                                    // Buscamos o nome do exame que agora está na tabela 'exames'
                                    $texto = ($ultimoExame->exame->nome ?? 'Exame') . ': ' . $ultimoExame->data_prevista->format('d/m H:i');
                                }
                                
                                if($progresso > 100) { 
                                    $cor = 'bg-red-600'; 
                                    $texto = 'Fora do Prazo'; 
                                } elseif($progresso > 50 && $p->status != 'Exame Agendado') { 
                                    $cor = 'bg-orange-500'; 
                                    $texto = 'Atrasado'; 
                                }
                            @endphp
                        
                            <div class="text-[10px] mb-1 font-bold uppercase tracking-wider {{ str_replace('bg-', 'text-', $cor) }}">
                                {{ $texto }} ({{ round($progresso) }}%)
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 shadow-inner">
                                <div class="{{ $cor }} h-2 rounded-full transition-all duration-500" 
                                    style="width: {{ min($progresso, 100) }}%">
                                </div>
                            </div>
                        @endif
                    </td>
                    
                    <td class="py-3 px-2 text-center">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150 shadow-sm border-gray-200">
                                    <div>Opções</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="url('/pacientes/'.$p->id.'/editar')">
                                    ✏️ Editar Cadastro
                                </x-dropdown-link>

                                @php $ultimoAgendamento = $p->agendamentos->where('status', 'Agendado')->first(); @endphp

                                @if($p->status == 'Exame Agendado' && $ultimoAgendamento)
                                    <button type="button" 
                                            onclick="abrirModalCancelamento('{{ $p->id }}', '{{ $p->nome }}', '{{ $ultimoAgendamento->id }}')"
                                            class="block w-full px-4 py-2 text-start text-sm text-red-600 hover:bg-gray-100 font-bold">
                                        ❌ Cancelar Exame
                                    </button>
                                @endif

                                <hr class="border-gray-100">
                                
                                <!-- O formulário agora envolve o botão para o 'closest(form)' funcionar -->
                                <form action="{{ route('pacientes.destroy', $p->id) }}" method="POST" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                        onclick="confirmarExclusao(this)" 
                                        class="block w-full px-4 py-2 text-start text-sm leading-5 text-red-600 hover:bg-red-50 transition duration-150 ease-in-out">
                                        🗑️ Remover Registro
                                    </button>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </td>
                </tr>
                @endforeach