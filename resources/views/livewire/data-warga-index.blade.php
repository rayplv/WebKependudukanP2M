<div>
    <h1 class="text-2xl font-bold text-[#4B0082] mb-6">DATA WARGA DESA</h1>

    <x-card class="mb-6 rounded-xl shadow-lg p-6"> {{-- Card styling --}}
        <h2 class="text-xl font-semibold text-[#4B0082] mb-4">Filter Data Warga</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <x-input-text wire:model.live.debounce.300ms="search" placeholder="Cari NIK, Nama, No. KK..."
                class="col-span-full md:col-span-2 lg:col-span-1 border-gray-300 rounded-md shadow-sm" />

            <x-input-select wire:model.live="filterRW" :options="$rwOptions" label="RW"
                class="border-gray-300 rounded-md shadow-sm" />
            <x-input-select wire:model.live="filterRT" :options="$rtOptions" label="RT"
                class="border-gray-300 rounded-md shadow-sm" />
            <x-input-select wire:model.live="filterPendidikan" :options="$pendidikanOptions" label="Pendidikan Terakhir"
                class="border-gray-300 rounded-md shadow-sm" />
            <x-input-select wire:model.live="filterStatusPernikahan" :options="$statusPernikahanOptions" label="Status Pernikahan"
                class="border-gray-300 rounded-md shadow-sm" />
            <x-input-select wire:model.live="filterTag" :options="$tagOptions" label="Tag"
                class="border-gray-300 rounded-md shadow-sm" />

            <div class="flex items-end justify-end col-span-full md:col-span-2 lg:col-span-1">
                <x-button wire:click="resetFilter" type="button" variant="secondary"
                    class="w-full bg-blue-100 hover:bg-blue-200 text-blue-700"> {{-- Adjusted button style --}}
                    <x-heroicon-o-arrow-path class="h-5 w-5 mr-2" /> {{-- Heroicon --}}
                    Reset Filter
                </x-button>
            </div>
        </div>
    </x-card>

    <div class="mb-4 text-gray-700">
        Jumlah Data Warga yang Ditemukan: <span class="font-bold">{{ number_format($dataWarga->total()) }}</span>
    </div>

    <x-card class="rounded-xl shadow-lg p-6"> {{-- Card styling --}}
        <x-table :headers="['Nama', 'NIK', 'No. KK', 'Tempat Tanggal Lahir', 'Jenis Kelamin', '']">
            @forelse($dataWarga as $data)
                <tr class="hover:bg-gray-50"> {{-- Hover effect for rows --}}
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $data->nama }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $data->nik }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $data->no_kk }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $data->tempat_tanggal_lahir }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $data->jenis_kelamin }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('data-warga.show', $data->id) }}"
                            class="text-blue-600 hover:text-blue-800 font-semibold px-3 py-1 rounded-md bg-blue-100">Detail</a>
                        {{-- Styled Detail button --}}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">No data
                        found.</td>
                </tr>
            @endforelse
        </x-table>

        <div class="mt-4">
            {{ $dataWarga->links('components.pagination') }}
        </div>
    </x-card>
</div>
