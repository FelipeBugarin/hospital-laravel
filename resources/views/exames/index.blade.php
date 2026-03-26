<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🧪 Gerenciar Tipos de Exames
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- FORMULÁRIO DE CADASTRO -->
            <div class="p-6 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Cadastrar Novo Tipo de Exame</h3>
                <form action="{{ route('exames.store') }}" method="POST" class="flex gap-4 items-end">
                    @csrf
                    <div class="flex-1">
                        <x-input-label for="nome" value="Nome do Exame (ex: Raio-X de Tórax)" />
                        <x-text-input id="nome" name="nome" type="text" class="mt-1 block w-full" required />
                    </div>
                    <x-primary-button>Salvar Exame</x-primary-button>
                </form>
            </div>

            <!-- LISTA DE EXAMES CADASTRADOS -->
            <div class="p-6 bg-white shadow sm:rounded-lg">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b text-gray-500 uppercase text-xs">
                            <th class="py-3 px-2">ID</th>
                            <th class="py-3 px-2">Nome do Exame</th>
                            <th class="py-3 px-2">Criado em</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($exames as $e)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-2 text-gray-400">#{{ $e->id }}</td>
                                <td class="py-3 px-2 font-bold">{{ $e->nome }}</td>
                                <td class="py-3 px-2 text-sm">{{ $e->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-4 text-center text-gray-500">Nenhum exame cadastrado.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
