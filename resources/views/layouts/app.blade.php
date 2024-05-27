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
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans antialiased">
    <x-banner />

    @if (auth()->user()->tipo_usuario == 'Administrador')
        <div class="min-h-screen bg-slate-700">
    @elseif (in_array(auth()->user()->tipo_usuario, ['Medico general', 'Medico especialista']))
        <div class="min-h-screen"
                style="background-image: radial-gradient(circle, #d16ba5, #c777b9, #ba83ca, #aa8fd8, #9a9ae1, #8e9ae2, #8199e3, #7299e3, #638ee0, #5483dd, #6d9bf8, #6283be);">
    @elseif (in_array(auth()->user()->tipo_usuario, ['Enfermeria consultorios', 'Enfermeria hospitalizacion']))
        <div class="min-h-screen bg-rose-200">
    @endif


    @livewire('navigation-menu')

    <!-- Page Heading -->
    @if (isset($header))
        <header class="bg-cyan-300 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    @if (auth()->user()->tipo_usuario == 'Administrador')
        <div class="flex flex-col items-center">
            <h1 class='text-4xl font-bold m-2 text-teal-50'>ADMIN</h1>
        </div>
    @endif

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>
    </div>

    @stack('modals')

    @livewireScripts
    <x-alert-modal></x-alert-modal>
    <x-confirm-modal></x-confirm-modal>
</body>

</html>
