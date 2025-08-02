<aside class="fixed left-0 top-0 flex flex-col h-screen bg-gradient-to-b from-[#376CB4] to-[#457BC5] shadow-xl w-64 z-10">
    <div class="p-6 flex flex-col h-full">
        {{-- User Profile Section --}}
        <div class="flex items-center mb-8 p-4 bg-white bg-opacity-20 rounded-xl backdrop-blur-sm border border-white border-opacity-30">
            <div class="w-12 h-12 bg-[#FFFFFF] rounded-full flex items-center justify-center mr-3 shadow-lg">
                <x-heroicon-o-user class="h-7 w-7 text-[#376CB4]" />
            </div>
            <div>
                @guest
                    <span class="font-bold text-white text-lg block">Guest</span>
                    <span class="text-[#ADC4DB] text-sm">Not Logged In</span>
                @endguest
                @auth    
                    <span class="font-bold text-white text-lg block">{{ Auth::user()->name }}</span>
                    <span class="text-[#ADC4DB] text-sm">Logged In</span>
                @endauth
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
            @auth
                @if(Auth::user()->role_id === 3)
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
                @endif
                {{-- Tombol Logout untuk user yang sudah login --}}
                <li>
                    <a href="#"
                        onclick="confirmLogout(event)"
                        class="flex items-center p-3 rounded-xl transition-all duration-300 group text-white hover:bg-white hover:bg-opacity-20 hover:transform hover:scale-105">
                        <x-heroicon-o-arrow-right-on-rectangle class="h-5 w-5 mr-4 flex-shrink-0 text-[#ADC4DB] group-hover:text-white" />
                        <span class="font-medium">Keluar</span>
                    </a>
                </li>
            @endauth
            
            @guest
                {{-- Tombol Login untuk guest --}}
                <li>
                    <a href="{{ route('login') }}"
                        class="flex items-center p-3 rounded-xl transition-all duration-300 group text-white hover:bg-white hover:bg-opacity-20 hover:transform hover:scale-105">
                        <x-heroicon-o-arrow-left-on-rectangle class="h-5 w-5 mr-4 flex-shrink-0 text-[#ADC4DB] group-hover:text-white" />
                        <span class="font-medium">Masuk</span>
                    </a>
                </li>
            @endguest
        </ul>
    </div>

    <!-- Form logout tersembunyi -->
    @auth
    <form id="logoutForm" method="POST" action="{{ route('logout') }}" style="display: none;">
        @csrf
    </form>
    @endauth

    <!-- Logout Confirmation Modal -->
    <div id="logoutModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 max-w-md mx-4 shadow-2xl">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-[#376CB4] to-[#457BC5] rounded-full flex items-center justify-center mr-4">
                    <x-heroicon-o-arrow-right-on-rectangle class="h-6 w-6 text-white" />
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Konfirmasi Keluar</h3>
            </div>
            <p class="text-gray-600 mb-6">Apakah Anda yakin ingin keluar dari sistem?</p>
            <div class="flex space-x-3 justify-end">
                <button onclick="closeLogoutModal()" type="button"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-all duration-200 text-sm font-medium">
                    Batal
                </button>
                <button onclick="confirmLogoutAction()" type="button"
                    class="px-4 py-2 bg-gradient-to-r from-[#376CB4] to-[#457BC5] text-white rounded-lg hover:from-[#2E5A99] hover:to-[#376CB4] transition-all duration-200 text-sm font-medium">
                    Keluar
                </button>
            </div>
        </div>
    </div>
</aside>

<script>
function confirmLogout(event) {
    event.preventDefault();
    document.getElementById('logoutModal').classList.remove('hidden');
    document.getElementById('logoutModal').classList.add('flex');
}

function closeLogoutModal() {
    document.getElementById('logoutModal').classList.add('hidden');
    document.getElementById('logoutModal').classList.remove('flex');
}

function confirmLogoutAction() {
    // Redirect to logout route or perform logout action
    document.getElementById('logoutForm').submit();
}
</script>