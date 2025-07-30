<x-guest-layout
    title="Login"
    heading="Masuk ke Akun"
>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form class="space-y-6" method="POST" action="{{ route('login') }}">
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
                <a href="{{ route('password.request') }}" class="font-medium text-[#699CCF] hover:text-[#376CB4] transition-colors duration-200">
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
</x-guest-layout>
