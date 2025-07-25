<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Warga Desa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-[#F3F4F6] font-sans antialiased">
    <div class="flex min-h-screen">
        {{-- Livewire component for the sidebar --}}
        @livewire('sidebar')

        <main class="flex-1 p-8 overflow-y-auto">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>

</html>
