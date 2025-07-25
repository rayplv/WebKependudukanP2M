<div>
    <h1 class="text-2xl font-bold text-[#4B0082] mb-6">Manajemen Akun</h1>

    <x-card class="rounded-xl shadow-lg p-6">
        <div class="flex justify-end mb-4">
            <a href="{{ route('manajemen-akun.create') }}">
                <x-button variant="primary" class="flex items-center">
                    <x-heroicon-o-plus-circle class="h-5 w-5 mr-2" /> {{-- Heroicon --}}
                    Tambah Akun Baru
                </x-button>
            </a>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <x-table :headers="['Nama', 'Email', 'Role', 'Aksi']">
            @forelse($accounts as $account)
                <tr class="hover:bg-gray-50"> {{-- Hover effect for rows --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $account->nama }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $account->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 capitalize">{{ $account->role }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <x-button wire:click="editAccount({{ $account->id }})" type="button" variant="info"
                            class="mr-2 px-3 py-1"> {{-- Smaller buttons --}}
                            <x-heroicon-o-pencil class="h-4 w-4" /> {{-- Heroicon --}}
                        </x-button>
                        <x-button wire:click="deleteAccount({{ $account->id }})" type="button" variant="danger"
                            class="px-3 py-1"> {{-- Smaller buttons --}}
                            <x-heroicon-o-trash class="h-4 w-4" /> {{-- Heroicon --}}
                        </x-button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">No accounts
                        found.</td>
                </tr>
            @endforelse
        </x-table>
    </x-card>

</div>
