<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital - @yield('titulo')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navbar fixa para todo o sistema -->
    <nav class="bg-blue-700 p-4 shadow-lg text-white font-bold">
        <div class="container mx-auto flex justify-between">
            <span>🏥 Hospital Central</span>
            <div class="space-x-4">
                <a href="/pacientes" class="hover:underline">Pacientes</a>
                <a href="#" class="opacity-50 cursor-not-allowed">Médicos (Em breve)</a>
            </div>
        </div>
    </nav>

    <!-- Onde o conteúdo das outras telas será "injetado" -->
    <main>
        @yield('conteudo')
    </main>
</body>
</html>
