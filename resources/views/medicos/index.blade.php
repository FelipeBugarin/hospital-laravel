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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 pb-40">
                
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
                                    <x-dropdown align="right" width="48">
                                        <x-slot name="trigger">
                                            <button class="inline-flex items-center px-3 py-2 border border-gray-200 text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150 shadow-sm">
                                                <div>Opções</div>
                                                <div class="ms-1">
                                                    <svg class="fill-current h-4 w-4" xmlns="http://w3.org" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </button>
                                        </x-slot>

                                        <x-slot name="content">
                                            <!-- Botão Editar (Ajuste a rota se necessário) -->
                                            <x-dropdown-link :href="url('/medicos/'.$m->id.'/editar')">
                                                ✏️ Editar Cadastro
                                            </x-dropdown-link>

                                            <hr class="border-gray-100">
                                            
                                            <!-- Botão Remover com SweetAlert -->
                                            <form action="{{ route('medicos.destroy', $m->id) }}" method="POST" class="m-0">
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
                        </tbody>
                    </table>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>