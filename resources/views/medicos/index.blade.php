<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                🩺 Equipe Médica
            </h2>
            <a href="{{ route('medicos.create') }}" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 font-bold transition shadow-sm">
                + Novo Médico
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if($medicos->isEmpty())
                    <div class="text-center py-8">
                        <p class="text-gray-500 italic">Nenhum médico cadastrado no sistema.</p>
                    </div>
                @else
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-gray-600 uppercase text-xs leading-normal border-b">
                                <th class="py-3 px-2">CRM</th>
                                <th class="py-3 px-2">Nome do Médico</th>
                                <th class="py-3 px-2">Especialidade</th>
                                <th class="py-3 px-2 text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm">
                            @foreach($medicos as $m)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="py-3 px-2 font-bold text-gray-400">{{ $m->crm }}</td>
                                <td class="py-3 px-2 font-semibold">{{ $m->nome }}</td>
                                <td class="py-3 px-2 text-indigo-600 font-medium">
                                    {{ $m->especialidade }}
                                </td>
                                <td class="py-3 px-2 text-center">
                                    <!-- Deixaremos os botões de editar/excluir para depois -->
                                    <span class="text-gray-300">Em breve</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>