<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🩺 Cadastrar Novo Médico
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-lg shadow-md">
                <form action="{{ route('medicos.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <x-input-label for="nome" value="Nome do Médico" />
                        <x-text-input id="nome" name="nome" type="text" class="mt-1 block w-full" required />
                        <x-input-error :messages="$errors->get('nome')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="crm" value="CRM (Registro Profissional)" />
                        <x-text-input id="crm" name="crm" type="text" class="mt-1 block w-full" required />
                    </div>

                    <div>
                        <x-input-label for="especialidade" value="Especialidade" />
                        <select name="especialidade" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="Clínico Geral">Clínico Geral</option>
                            <option value="Cardiologista">Cardiologista</option>
                            <option value="Ortopedista">Ortopedista</option>
                            <option value="Pediatra">Pediatra</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ml-4">
                            Salvar Médico
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>