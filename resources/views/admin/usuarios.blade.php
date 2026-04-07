<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            👥 Gerenciamento de Usuários
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- SEÇÃO: PENDENTES -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-orange-500">
                <h3 class="text-lg font-bold text-gray-700 mb-4 uppercase">⏳ Aguardando Aprovação</h3>
                @if($usuariosPendentes->isEmpty())
                    <p class="text-gray-500 italic">Nenhum usuário pendente.</p>
                @else
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b text-gray-400 text-xs uppercase">
                                <th class="py-2">Nome</th>
                                <th class="py-2">E-mail</th>
                                <th class="py-2 text-center">Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usuariosPendentes as $u)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 font-semibold">{{ $u->name }}</td>
                                <td class="py-3 text-gray-600">{{ $u->email }}</td>
                                <td class="py-3 text-center">
                                    <form action="{{ route('usuarios.aprovar', $u->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="bg-green-500 text-white px-4 py-1 rounded text-xs font-bold hover:bg-green-600 transition">
                                            ✅ Aprovar Acesso
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <!-- SEÇÃO: ATIVOS -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                <h3 class="text-lg font-bold text-gray-700 mb-4 uppercase">✔️ Usuários Ativos</h3>
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b text-gray-400 text-xs uppercase">
                            <th class="py-2">Nome</th>
                            <th class="py-2">E-mail</th>
                            <th class="py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuariosAprovados as $u)
                        <tr class="border-b">
                            <td class="py-2">{{ $u->name }}</td>
                            <td class="py-2">{{ $u->email }}</td>
                            <td class="py-2">
                                <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full text-[10px] font-black">ATIVO</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
