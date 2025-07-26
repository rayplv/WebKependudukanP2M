<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Warga Desa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-[#FFF9FD] font-sans antialiased">
    <div class="flex min-h-screen">
        {{-- Livewire component for the sidebar --}}
        @livewire('sidebar')

        {{-- Main content area --}}
        <div class="flex-1 flex flex-col ml-64">
            {{-- Header --}}
            <header class="bg-[#C5B6E1] p-6 shadow-lg">
                <h1 class="text-2xl font-bold text-[#4E347E]">DATA WARGA DESA</h1>
            </header>

            {{-- Main content --}}
            <main class="flex-1 p-6 overflow-y-auto">
                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
</body>

</html>
