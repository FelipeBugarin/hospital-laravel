<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Hospital - Novo Paciente</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
        <h1 class="text-xl font-bold mb-4">Cadastrar Novo Paciente</h1>
        
        <form action="/pacientes/salvar" method="POST">
            @csrf <!-- ESSENCIAL: Proteção de segurança do Laravel -->
            
            <div class="mb-4">
                <label class="block mb-1">Nome do Paciente:</label>
                <input type="text" name="nome" class="w-full border p-2 rounded" required>
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
        </form>
    </div>
</body>
</html>
