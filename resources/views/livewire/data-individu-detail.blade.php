<div>
    <h1 class="text-2xl font-bold text-[#4B0082] mb-6">DATA WARGA DESA</h1>

    <div class="mb-4">
        <a href="{{ route('data-warga.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-800">
            <x-heroicon-o-arrow-left class="h-5 w-5 mr-2" /> {{-- Heroicon --}}
            Detail Data Warga:
        </a>
    </div>

    <x-card class="rounded-xl shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-semibold text-gray-800">{{ $resident->nama_lengkap }}</h2>
                <p class="text-gray-600">NIK: {{ $resident->nik }}</p>
            </div>
            <div class="flex space-x-2">
                <x-button wire:click="editData" type="button" variant="info"
                    class="bg-blue-500 hover:bg-blue-600 text-white flex items-center"> {{-- Adjusted button style --}}
                    <x-heroicon-o-pencil class="h-4 w-4 mr-2" /> {{-- Heroicon --}}
                    Edit Data
                </x-button>
                <x-button wire:click="hapusData" type="button" variant="danger"
                    class="bg-red-600 hover:bg-red-700 text-white flex items-center"> {{-- Adjusted button style --}}
                    <x-heroicon-o-trash class="h-4 w-4 mr-2" /> {{-- Heroicon --}}
                    Hapus Data
                </x-button>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <p class="text-lg font-medium text-gray-700 mb-6">Status: <span
                class="{{ $resident->status === 'Hidup' ? 'text-green-600' : 'text-red-600' }} font-bold">{{ $resident->status }}</span>
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h3 class="text-lg font-semibold text-[#4B0082] mb-4">Informasi Pribadi</h3> {{-- Header color --}}
                <dl class="grid grid-cols-2 gap-x-4 gap-y-2 text-sm text-gray-700">
                    <dt class="font-semibold text-gray-800">Nomor KK:</dt>
                    <dd>{{ $resident->nomor_kk }}</dd>

                    <dt class="font-semibold text-gray-800">Nomor NIK:</dt>
                    <dd>{{ $resident->nik }}</dd>

                    <dt class="font-semibold text-gray-800">Nama Lengkap:</dt>
                    <dd>{{ $resident->nama_lengkap }}</dd>

                    <dt class="font-semibold text-gray-800">Tempat, Tanggal Lahir:</dt>
                    <dd>{{ $resident->tempat_tanggal_lahir }}</dd>

                    <dt class="font-semibold text-gray-800">Usia:</dt>
                    <dd>{{ $resident->usia }}</dd>

                    <dt class="font-semibold text-gray-800">Pendidikan Terakhir:</dt>
                    <dd>{{ $resident->pendidikan_terakhir }}</dd>

                    <dt class="font-semibold text-gray-800">Gol Darah:</dt>
                    <dd>{{ $resident->gol_darah }}</dd>

                    <dt class="font-semibold text-gray-800">Agama:</dt>
                    <dd>{{ $resident->agama }}</dd>

                    <dt class="font-semibold text-gray-800">Status Pernikahan:</dt>
                    <dd>{{ $resident->status_pernikahan }}</dd>

                    <dt class="font-semibold text-gray-800">RT:</dt>
                    <dd>{{ $resident->rt }}</dd>

                    <dt class="font-semibold text-gray-800">RW:</dt>
                    <dd>{{ $resident->rw }}</dd>

                    <dt class="font-semibold text-gray-800">Alamat Lengkap:</dt>
                    <dd>{{ $resident->alamat_lengkap }}</dd>

                    <dt class="font-semibold text-gray-800">Penyandang Disabilitas:</dt>
                    <dd>{{ $resident->penyandang_disabilitas }}</dd>
                </dl>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-[#4B0082] mb-4">Keluarga dalam KK</h3> {{-- Header color --}}
                <x-table :headers="['Hubungan', 'Nama Anggota', 'NIK']">
                    @foreach ($resident->keluarga_dalam_kk as $member)
                        <tr class="hover:bg-gray-50"> {{-- Hover effect for rows --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $member->hubungan }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $member->nama_anggota }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $member->nik }}</td>
                        </tr>
                    @endforeach
                </x-table>
            </div>
        </div>
    </x-card>
</div>
