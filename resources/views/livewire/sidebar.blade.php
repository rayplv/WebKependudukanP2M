<aside class="relative flex flex-col h-screen bg-white shadow-md w-64"> {{-- Fixed width sidebar --}}
    <div class="p-6 flex flex-col h-full">
        <div class="flex items-center mb-6 justify-start">
            <x-heroicon-o-user-circle class="h-10 w-10 text-gray-500 mr-3" />
            <span class="font-semibold text-gray-800 text-lg">SuperAdmin</span>
        </div>

        <ul class="space-y-1 flex-1">
            <li>
                <a href="{{ route('dashboard') }}"
                    class="flex items-center p-2 rounded-md transition-colors duration-200
                {{ $currentRoute === 'dashboard' ? 'bg-gradient-to-r from-blue-100 to-blue-200 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    <x-heroicon-o-home class="h-5 w-5 mr-3 flex-shrink-0" />
                    <span>Dasbor</span>
                </a>
            </li>
            <li>
                <a href="{{ route('data-warga.index') }}"
                    class="flex items-center p-2 rounded-md transition-colors duration-200
                {{ Str::startsWith($currentRoute, 'data-warga') && !Str::contains($currentRoute, '.create') && !Str::contains($currentRoute, '.show') ? 'bg-gradient-to-r from-blue-100 to-blue-200 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    <x-heroicon-o-users class="h-5 w-5 mr-3 flex-shrink-0" />
                    <span>Data Warga</span>
                </a>
            </li>
            <li>
                <a href="{{ route('data-warga.create') }}"
                    class="flex items-center p-2 rounded-md transition-colors duration-200
                {{ $currentRoute === 'data-warga.create' ? 'bg-gradient-to-r from-blue-100 to-blue-200 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    <x-heroicon-o-plus-circle class="h-5 w-5 mr-3 flex-shrink-0" />
                    <span>Tambah Data</span>
                </a>
            </li>
        </ul>

        <ul class="space-y-1 pt-6 border-t border-gray-200 mt-auto"> {{-- mt-auto pushes to bottom --}}
            <li>
                <a href="{{ route('manajemen-akun') }}"
                    class="flex items-center p-2 rounded-md transition-colors duration-200
                {{ Str::startsWith($currentRoute, 'manajemen-akun') ? 'bg-gradient-to-r from-blue-100 to-blue-200 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    <x-heroicon-o-cog class="h-5 w-5 mr-3 flex-shrink-0" />
                    <span>Manajemen Akun</span>
                </a>
            </li>
            <li>
                <a href="#"
                    class="flex items-center p-2 rounded-md text-gray-600 hover:bg-gray-100 transition-colors duration-200">
                    <x-heroicon-o-question-mark-circle class="h-5 w-5 mr-3 flex-shrink-0" />
                    <span>Tentang</span>
                </a>
            </li>
            <li>
                <a href="#" wire:click="logout"
                    class="flex items-center p-2 rounded-md text-gray-600 hover:bg-gray-100 transition-colors duration-200">
                    <x-heroicon-o-arrow-left-on-rectangle class="h-5 w-5 mr-3 flex-shrink-0" />
                    <span>Keluar</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
