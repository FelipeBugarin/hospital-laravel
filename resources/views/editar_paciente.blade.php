<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Hospital - Novo Paciente</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
        <h1 class="text-xl font-bold mb-4">Editar Paciente</h1>
        
        <form action="/pacientes/{{ $paciente->id }}" method="POST">
            @csrf <!-- ESSENCIAL: Proteção de segurança do Laravel -->
            @method('PUT') <!-- O Laravel precisa disso para entender que é um PUT -->
            
            <div class="mb-4">
                <label class="block mb-1">Nome do Paciente:</label>
                <input type="text" name="nome" class="w-full border p-2 rounded" value="{{ $paciente->nome }}" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Status:</label>
                <select name="status" class="w-full border p-2 rounded">
                    <option value="Estável">Estável</option>
                    <option value="Observação">Observação</option>
                    <option value="Crítico">Crítico</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Salvar Paciente
            </button>
            <a href="/pacientes" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 font-bold transition">
                Voltar para a Lista
            </a>
        </form>
    </div>
</body>
</html>
