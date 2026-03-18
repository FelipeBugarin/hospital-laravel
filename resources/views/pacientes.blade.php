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
        
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-gray-600 uppercase text-sm leading-normal border-b">
                    <th class="py-3 px-2">ID</th>
                    <th class="py-3 px-2">Nome</th>
                    <th class="py-3 px-2">Status</th>
                    <th class="py-3 px-2 text-center">Ações</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm font-light">
                @foreach($lista as $p)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-4 px-2">{{ $p->nome }}</td>
                    
                    <!-- Alteração de Status Direta -->
                    <td class="py-4 px-2">
                        <form action="/pacientes/{{ $p->id }}/status" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="text-sm border rounded p-1">
                                <option value="Estável" {{ $p->status == 'Estável' ? 'selected' : '' }}>Estável</option>
                                <option value="Observação" {{ $p->status == 'Observação' ? 'selected' : '' }}>Observação</option>
                                <option value="Crítico" {{ $p->status == 'Crítico' ? 'selected' : '' }}>Crítico</option>
                                <option value="Alta" {{ $p->status == 'Alta' ? 'selected' : '' }}>Alta</option>
                            </select>
                        </form>
                    </td>

                    <!-- Progress Bar de Prazo -->
                    <td class="py-4 px-2 w-64">
                        @if($p->status == 'Alta')
                            <!-- Se for Alta, mostra apenas o selo verde de finalizado -->
                            <div class="flex items-center gap-2">
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold border border-green-200">
                                    ✅ Recebeu Alta
                                </span>
                            </div>
                        @else
                            <!-- Se NÃO for Alta, mostra a lógica da Progress Bar -->
                            @php
                                $progresso = $p->progresso;
                                $cor = 'bg-green-500';
                                $texto = 'No Prazo';
                                
                                if($progresso > 100) { 
                                    $cor = 'bg-red-600'; 
                                    $texto = 'Fora do Prazo'; 
                                } elseif($progresso > 50) { 
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
                        <div class="flex justify-center items-center gap-4">
                            <!-- Link Editar (Fora do Form) -->
                            <a href="/pacientes/{{ $p->id }}/editar" class="text-blue-500 hover:text-blue-700 font-bold transition">
                                Editar
                            </a>

                            <!-- Form Excluir -->
                            <form action="/pacientes/{{ $p->id }}" method="POST" class="form-excluir inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmarExclusao(this)" class="text-red-500 hover:text-red-700 font-bold transition">
                                    Excluir
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
@endsection
