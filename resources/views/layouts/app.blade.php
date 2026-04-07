<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->

        <!-- 1. Primeiro carregamos a biblioteca (O "Cérebro") -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <!-- Script para Mensagens de Sucesso e Exclusão -->
        <script>
            // 1. Alerta de Sucesso (após cadastrar/editar)
            @if(session('sucesso'))
                Swal.fire({
                    title: 'Sucesso!',
                    text: "{{ session('sucesso') }}",
                    icon: 'success',
                    confirmButtonColor: '#2563eb'
                });
            @endif

            @if(session('erro'))
                Swal.fire({
                    title: 'Acesso Negado',
                    text: "{{ session('erro') }}",
                    icon: 'error',
                    confirmButtonColor: '#d33'
                });
            @endif

            // 2. Confirmação de Exclusão Moderna
            function confirmarExclusao(botao) {
                Swal.fire({
                    title: 'Tem certeza?',
                    text: "Você não poderá reverter isso!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sim, deletar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        botao.closest('form').submit();
                    }
                })
            }
        </script>

    </body>
</html>
