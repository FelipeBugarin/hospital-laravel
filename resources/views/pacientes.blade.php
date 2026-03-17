<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Hospital - Pacientes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-6 text-blue-600">Painel do Hospital - Lista de Pacientes</h1>
        
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
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
