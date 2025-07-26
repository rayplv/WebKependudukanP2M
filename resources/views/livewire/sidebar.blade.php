<aside class="fixed left-0 top-0 flex flex-col h-screen bg-gradient-to-b from-[#376CB4] to-[#457BC5] shadow-xl w-64 z-10">
    <div class="p-6 flex flex-col h-full">
        {{-- User Profile Section --}}
        <div class="flex items-center mb-8 p-4 bg-white bg-opacity-20 rounded-xl backdrop-blur-sm border border-white border-opacity-30">
            <div class="w-12 h-12 bg-[#FFFFFF] rounded-full flex items-center justify-center mr-3 shadow-lg">
                <x-heroicon-o-user class="h-7 w-7 text-[#376CB4]" />
            </div>
            <div>
                <span class="font-bold text-white text-lg block">Admin</span>
                <span class="text-[#ADC4DB] text-sm">Super Admin</span>
            </div>
        </div>

        {{-- Menu Section --}}
        <div class="mb-4">
            <span class="text-[#ADC4DB] text-sm font-medium mb-3 block uppercase tracking-wide">Menu</span>
        </div>

        <ul class="space-y-2 flex-1">
            <li>
                <a href="{{ route('dashboard') }}"
                    class="flex items-center p-3 rounded-xl transition-all duration-300 group relative
                {{ $currentRoute === 'dashboard' ? 'bg-white text-[#376CB4] shadow-lg transform scale-105' : 'text-white hover:bg-white hover:bg-opacity-20 hover:transform hover:scale-105' }}">
                    <x-heroicon-o-home class="h-5 w-5 mr-4 flex-shrink-0 {{ $currentRoute === 'dashboard' ? 'text-[#376CB4]' : 'text-[#ADC4DB] group-hover:text-white' }}" />
                    <span class="font-medium">Dashboard</span>
                    @if($currentRoute === 'dashboard')
                        <div class="absolute right-2 w-2 h-2 bg-[#376CB4] rounded-full"></div>
                    @endif
                </a>
            </li>
            <li>
                <a href="{{ route('data-warga.index') }}"
                    class="flex items-center p-3 rounded-xl transition-all duration-300 group relative
                {{ Str::startsWith($currentRoute, 'data-warga') && !Str::contains($currentRoute, '.create') && !Str::contains($currentRoute, '.show') ? 'bg-white text-[#376CB4] shadow-lg transform scale-105' : 'text-white hover:bg-white hover:bg-opacity-20 hover:transform hover:scale-105' }}">
                    <x-heroicon-o-users class="h-5 w-5 mr-4 flex-shrink-0 {{ Str::startsWith($currentRoute, 'data-warga') && !Str::contains($currentRoute, '.create') && !Str::contains($currentRoute, '.show') ? 'text-[#376CB4]' : 'text-[#ADC4DB] group-hover:text-white' }}" />
                    <span class="font-medium">Data Warga</span>
                    @if(Str::startsWith($currentRoute, 'data-warga') && !Str::contains($currentRoute, '.create') && !Str::contains($currentRoute, '.show'))
                        <div class="absolute right-2 w-2 h-2 bg-[#376CB4] rounded-full"></div>
                    @endif
                </a>
            </li>
        </ul>

        {{-- Bottom Menu --}}
        <ul class="space-y-2 pt-6 border-t border-white border-opacity-30">
            <li>
                <a href="{{ route('manajemen-akun') }}"
                    class="flex items-center p-3 rounded-xl transition-all duration-300 group relative
                {{ Str::startsWith($currentRoute, 'manajemen-akun') ? 'bg-white text-[#376CB4] shadow-lg transform scale-105' : 'text-white hover:bg-white hover:bg-opacity-20 hover:transform hover:scale-105' }}">
                    <x-heroicon-o-cog class="h-5 w-5 mr-4 flex-shrink-0 {{ Str::startsWith($currentRoute, 'manajemen-akun') ? 'text-[#376CB4]' : 'text-[#ADC4DB] group-hover:text-white' }}" />
                    <span class="font-medium">Kelola Akun</span>
                    @if(Str::startsWith($currentRoute, 'manajemen-akun'))
                        <div class="absolute right-2 w-2 h-2 bg-[#376CB4] rounded-full"></div>
                    @endif
                </a>
            </li>
            <li>
                <a href="#"
                    class="flex items-center p-3 rounded-xl transition-all duration-300 group text-white hover:bg-white hover:bg-opacity-20 hover:transform hover:scale-105">
                    <x-heroicon-o-arrow-right-on-rectangle class="h-5 w-5 mr-4 flex-shrink-0 text-[#ADC4DB] group-hover:text-white" />
                    <span class="font-medium">Keluar</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
