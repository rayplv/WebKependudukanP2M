<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Kependudukan</title>
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
                Masuk ke Akun
            </h2>
            <p class="text-sm text-[#699CCF]">
                Sistem Kependudukan
            </p>
        </div>

        <!-- Login Form -->
        <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-8">
            <form class="space-y-6" method="POST">
                @csrf
                
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-[#4E347E] mb-2">
                        Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-[#699CCF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                        </div>
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            required 
                            class="block w-full pl-10 pr-3 py-3 border border-[#ADC4DB] rounded-md placeholder-[#699CCF] focus:outline-none focus:ring-2 focus:ring-[#376CB4] focus:border-[#376CB4] transition-colors duration-200"
                            placeholder="Masukkan email Anda"
                        >
                    </div>
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-[#4E347E] mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-[#699CCF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <input 
                            id="password" 
                            name="password" 
                            type="password" 
                            required 
                            class="block w-full pl-10 pr-3 py-3 border border-[#ADC4DB] rounded-md placeholder-[#699CCF] focus:outline-none focus:ring-2 focus:ring-[#376CB4] focus:border-[#376CB4] transition-colors duration-200"
                            placeholder="Masukkan password Anda"
                        >
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input 
                            id="remember-me" 
                            name="remember-me" 
                            type="checkbox" 
                            class="h-4 w-4 text-[#376CB4] focus:ring-[#376CB4] border-[#ADC4DB] rounded"
                        >
                        <label for="remember-me" class="ml-2 block text-sm text-[#4E347E]">
                            Ingat saya
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="#" class="font-medium text-[#699CCF] hover:text-[#376CB4] transition-colors duration-200">
                            Lupa password?
                        </a>
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button 
                        type="submit" 
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-[#376CB4] to-[#457BC5] hover:from-[#2D9BB9] hover:to-[#376CB4] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#376CB4] transition-all duration-200 shadow-lg hover:shadow-xl"
                    >
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-white group-hover:text-gray-100" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                            </svg>
                        </span>
                        Masuk
                    </button>
                </div>
            </form>
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
        <svg class="absolute inset-0 h-full w-full stroke-[#ADC4DB]" fill="none" viewBox="0 0 400 400" aria-hidden="true">
            <defs>
                <pattern id="pattern" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M0 40L40 0H20L0 20M40 40V20L20 40"></path>
                </pattern>
            </defs>
            <rect width="100%" height="100%" stroke-width="0" fill="url(#pattern)" opacity="0.1"></rect>
        </svg>
    </div>
</body>
</html>
