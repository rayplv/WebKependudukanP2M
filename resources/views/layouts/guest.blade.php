@props([
    'title' => '[TITLE]',
    'heading' => '[HEADING]'
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title }} - {{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-50 min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Header -->
            <div class="text-center">
                <div class="mx-auto h-16 w-16 bg-gradient-to-r from-[#376CB4] to-[#457BC5] rounded-full flex items-center justify-center mb-4 shadow-lg">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-[#4E347E] mb-2">
                    {{ $heading }}
                </h2>
                <p class="text-sm text-[#699CCF]">
                    Sistem Kependudukan
                </p>
            </div>

            <!-- Login Form -->
            <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-8">
                {{ $slot }}
            </div>

            <!-- Footer -->
            <div class="text-center">
                <p class="text-sm text-[#699CCF]">
                    © 2025 Sistem Kependudukan. All rights reserved.
                </p>
            </div>
        </div>

        <!-- Background Pattern -->
        <div class="fixed inset-0 -z-10 overflow-hidden">
            <svg class="absolute inset-0 w-full h-full object-cover stroke-[#ADC4DB]" fill="none" viewBox="0 0 400 400" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
            <defs>
                <pattern id="pattern" width="40" height="40" patternUnits="userSpaceOnUse">
                <path d="M0 40L40 0H20L0 20M40 40V20L20 40"></path>
                </pattern>
            </defs>
            <rect width="100%" height="100%" stroke-width="0" fill="url(#pattern)" opacity="0.2"></rect>
            </svg>
        </div>
    </body>
</html>
