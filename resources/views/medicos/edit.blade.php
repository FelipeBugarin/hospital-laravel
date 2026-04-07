<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ✏️ Editar Médico: {{ $medico->nome }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('medicos.update', $medico->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <!-- CRM (Pode deixar desabilitado se não quiser que mude o CRM) -->
                        <div>
                            <label class="block font-medium text-sm text-gray-700">CRM</label>
                            <input type="text" name="crm" value="{{ $medico->crm }}" 
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" required>
                        </div>

                        <!-- Nome -->
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Nome do Médico</label>
                            <input type="text" name="nome" value="{{ $medico->nome }}" 
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200" required>
                        </div>

                        <!-- Especialidade -->
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Especialidade</label>
                            <select name="especialidade" class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200">
                                <option value="Cardiologia" {{ $medico->especialidade == 'Cardiologia' ? 'selected' : '' }}>Cardiologia</option>
                                <option value="Clínico Geral" {{ $medico->especialidade == 'Clínico Geral' ? 'selected' : '' }}>Clínico Geral</option>
                                <option value="Ortopedia" {{ $medico->especialidade == 'Ortopedia' ? 'selected' : '' }}>Ortopedia</option>
                                <option value="Pediatria" {{ $medico->especialidade == 'Pediatria' ? 'selected' : '' }}>Pediatria</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-2">
                        <a href="{{ route('medicos.index') }}" class="px-4 py-2 bg-gray-200 rounded-md text-sm font-bold hover:bg-gray-300">
                            Cancelar
                        </a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-bold hover:bg-blue-700">
                            Salvar Alterações
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
