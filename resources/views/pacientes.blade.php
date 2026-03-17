<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Hospital - Pacientes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
        <!-- CABEÇALHO COM BOTÃO -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-blue-600">Painel do Hospital - Pacientes</h1>
            <a href="/pacientes/novo" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 font-bold transition">
                + Novo Paciente
            </a>
        </div>
        
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b">
                    <th class="py-2">ID</th>
                    <th class="py-2">Nome</th>
                    <th class="py-2">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lista as $p)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-2">{{ $p->id }}</td>
                    <td class="py-2">{{ $p->nome }}</td>
                    <td class="py-2 font-semibold">{{ $p->status }}</td>
                    <td class="py-2">
                        <form action="/pacientes/{{ $p->id }}" method="POST" onsubmit="return confirm('Tem certeza?')">
                            @csrf
                            @method('DELETE') <!-- O Laravel precisa disso para entender que é um DELETE -->
                            <button type="submit" class="text-red-600 hover:underline">Excluir</button>
                            <a href="/pacientes/{{ $p->id }}/editar" class="text-blue-600 hover:underline ml-2">Editar</a>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
