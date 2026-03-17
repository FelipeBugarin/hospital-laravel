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
                <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                    <td class="py-3 px-2 font-bold">{{ $p->id }}</td>
                    <td class="py-3 px-2 font-medium">{{ $p->nome }}</td>
                    <td class="py-3 px-2">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $p->status == 'Crítico' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ $p->status }}
                        </span>
                    </td>
                    <td class="py-3 px-2 text-center">
                        <div class="flex justify-center items-center gap-4">
                            <!-- Link Editar (Fora do Form) -->
                            <a href="/pacientes/{{ $p->id }}/editar" class="text-blue-500 hover:text-blue-700 font-bold transition">
                                Editar
                            </a>

                            <!-- Form Excluir -->
                            <form action="/pacientes/{{ $p->id }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir {{ $p->nome }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-bold transition">
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
