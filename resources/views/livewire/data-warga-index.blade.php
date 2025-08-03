<div>
    <!-- Flash Message -->
    @if (session()->has('message'))
        <div class="mb-4 p-4 rounded-lg {{ session('type') == 'success' ? 'bg-green-100 border border-green-400 text-green-700' : 'bg-red-100 border border-red-400 text-red-700' }}">
            <div class="flex items-center">
                @if(session('type') == 'success')
                    <x-heroicon-o-check-circle class="h-5 w-5 mr-2" />
                @else
                    <x-heroicon-o-exclamation-circle class="h-5 w-5 mr-2" />
                @endif
                {{ session('message') }}
            </div>
        </div>
    @endif

    <!-- Header dengan Judul dan Tombol -->
    <div class="flex justify-between items-center mb-4">
        @auth
            <h2 class="text-xl font-semibold text-[#4E347E]">Filter Data Warga</h2>
            <x-button wire:click="openTambahModal" type="button" variant="primary"
                class="bg-[#376CB4] hover:bg-[#457BC5] text-white px-6 py-2 rounded-lg shadow-md transition-all duration-300 hover:shadow-lg">
                <x-heroicon-o-plus class="h-5 w-5 mr-2" />
                Tambah Data Warga
            </x-button>
        @else
            <h2 class="text-xl font-semibold text-[#4E347E]">Pencarian Data Warga</h2>
        @endauth
    </div>

    <x-card class="mb-6 bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 rounded-xl shadow-sm p-6">
        @auth
            <!-- Filter lengkap untuk admin -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <x-input-text wire:model.live.debounce.300ms="search" placeholder="Cari NIK, Nama, No. KK..."
                    class="col-span-full md:col-span-2 lg:col-span-2 border-gray-300 rounded-md shadow-sm" />

                <x-input-select wire:model.live="filterRW" :options="$rwOptions ?? []" placeholder="RW"
                    class="border-gray-300 rounded-md shadow-sm" />
                <x-input-select wire:model.live="filterRT" :options="$rtOptions ?? []" placeholder="RT"
                    class="border-gray-300 rounded-md shadow-sm" />
                
                <x-input-select wire:model.live="filterPendidikan" :options="$pendidikanOptions ?? []" placeholder="Pendidikan Terakhir"
                    class="border-gray-300 rounded-md shadow-sm" />
                <x-input-select wire:model.live="filterStatusPernikahan" :options="$statusPernikahanOptions ?? []" placeholder="Status Pernikahan"
                    class="border-gray-300 rounded-md shadow-sm" />
                <x-input-select wire:model.live="filterTag" :options="$tagOptions ?? []" placeholder="Tag"
                    class="border-gray-300 rounded-md shadow-sm" />

                <x-button 
                    onclick="
                        document.querySelectorAll('input, select').forEach(el => el.value = ''); 
                        window.location.href = '{{ route('data-warga.index') }}';
                    " 
                    type="button" 
                    variant="secondary"
                    class="bg-blue-100 hover:bg-blue-200 text-blue-700">
                    <x-heroicon-o-arrow-path class="h-5 w-5 mr-2" />
                    Reset Filter
                </x-button>
            </div>
        @else
            <!-- Pencarian sederhana untuk user tidak login -->
            <div class="grid grid-cols-1 gap-4">
                <x-input-text wire:model.live.debounce.300ms="search" placeholder="Masukkan NIK untuk mencari..."
                    class="border-gray-300 rounded-md shadow-sm" />
            </div>
            
            @if(empty($search))
                <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <div class="flex items-center">
                        <x-heroicon-o-information-circle class="h-5 w-5 text-yellow-600 mr-2" />
                        <span class="text-yellow-800 text-sm">
                            Silakan masukkan NIK untuk mencari data warga.
                        </span>
                    </div>
                </div>
            @endif
        @endauth
    </x-card>

    <div class="mb-4 flex justify-between items-center">
        <div class="text-gray-700">
            @auth
                Jumlah Data Warga yang Ditemukan: <span class="font-bold">{{ number_format($dataWarga->total()) }}</span>
            @else
                @if(!empty($search))
                    Hasil Pencarian NIK: <span class="font-bold">{{ number_format($dataWarga->total()) }}</span> data ditemukan
                @else
                    <span class="text-gray-500">Masukkan NIK untuk melihat data</span>
                @endif
            @endauth
        </div>
    </div>

    <x-card class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Nama</th>
                        @auth
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">NIK</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">No. KK</th>
                        @else
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">NIK</th>
                        @endauth
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Tempat Tanggal Lahir</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Jenis Kelamin</th>
                        <th class="px-4 py-3 text-right text-sm font-medium text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($dataWarga as $data)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center">
                                    <x-heroicon-o-user class="h-4 w-4 mr-2 text-gray-400" />
                                    <span class="text-sm font-medium text-gray-900">{{ $data->nama }}</span>
                                </div>
                            </td>
                            @auth
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-mono text-gray-600">
                                    {{ $data->nik }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-mono text-gray-600">
                                    {{ $data->no_kk_id }}
                                </td>
                            @else
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-mono text-gray-600">
                                    {{ substr($data->nik, 0, -6) . '******' }}
                                </td>
                            @endauth
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">{{ $data->tempat_tanggal_lahir }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full 
                                    {{ $data->jenis_kelamin === 'Laki-laki' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-pink-50 text-pink-700 border border-pink-200' }}">
                                    {{ $data->jenis_kelamin }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('data-warga.show', $data->nik) }}"
                                    class="inline-flex items-center px-3 py-1.5 bg-gray-100 text-gray-700 border border-gray-300 rounded-md hover:bg-gray-200 transition-colors duration-150 text-xs font-medium">
                                    <x-heroicon-o-eye class="h-4 w-4 mr-1" />
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->check() ? '6' : '5' }}" class="px-6 py-8 whitespace-nowrap text-center text-sm text-[#717171]">
                                <div class="flex flex-col items-center justify-center">
                                    <x-heroicon-o-user-group class="h-12 w-12 text-[#ADC4DB] mb-2" />
                                    @if(!auth()->check() && empty($search))
                                        <span>Masukkan NIK untuk mencari data warga</span>
                                    @else
                                        <span>Tidak ada data warga yang ditemukan</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex justify-center space-x-2">
            {{-- Tombol Sebelumnya --}}
            @if ($dataWarga->onFirstPage())
                <button disabled class="px-4 py-2 bg-gray-200 text-gray-500 rounded">Sebelumnya</button>
            @else
                <button onclick="window.location.href='{{ $dataWarga->previousPageUrl() }}'" class="px-4 py-2 bg-[#376CB4] text-white rounded hover:bg-[#457BC5]">Sebelumnya</button>
            @endif

            {{-- Tombol Nomor Halaman --}}
            @php
                $start = max($dataWarga->currentPage() - 2, 1);
                $end = min($start + 3, $dataWarga->lastPage());
                $start = max($end - 3, 1);
            @endphp
            @for ($i = $start; $i <= $end; $i++)
                @if ($i == $dataWarga->currentPage())
                    <button class="px-4 py-2 bg-[#376CB4] text-white rounded font-bold">{{ $i }}</button>
                @else
                    <button onclick="window.location.href='{{ $dataWarga->url($i) }}'" class="px-4 py-2 bg-white text-[#376CB4] border border-[#376CB4] rounded hover:bg-[#457BC5] hover:text-white">{{ $i }}</button>
                @endif
            @endfor

            {{-- Tombol Selanjutnya --}}
            @if ($dataWarga->hasMorePages())
                <button onclick="window.location.href='{{ $dataWarga->nextPageUrl() }}'" class="px-4 py-2 bg-[#376CB4] text-white rounded hover:bg-[#457BC5]">Selanjutnya</button>
            @else
                <button disabled class="px-4 py-2 bg-gray-200 text-gray-500 rounded">Selanjutnya</button>
            @endif
        </div>

        <div class="mt-4">
            {{ $dataWarga->links('components.pagination') }}
        </div>
    </x-card>

    <!-- Modal Tambah Data Warga - Gunakan wire:ignore untuk mencegah re-render -->
    @auth
        @if($showTambahModal)
        <div wire:ignore.self class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" 
                    wire:click="closeTambahModal"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    
                    <div class="bg-white px-6 pt-6 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-[#4E347E]" id="modal-title">
                                <x-heroicon-o-user-plus class="h-6 w-6 inline mr-2 text-[#376CB4]" />
                                Tambah Data Warga Baru
                            </h3>
                            <button wire:click="closeTambahModal" class="text-gray-400 hover:text-gray-600">
                                <x-heroicon-o-x-mark class="h-6 w-6" />
                            </button>
                        </div>

                        <form wire:submit.prevent="simpanDataWarga" class="space-y-4">
                            <!-- Form Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Data Pribadi -->
                                <div class="space-y-4">
                                    <h4 class="font-medium text-[#4E347E] border-b border-[#ADC4DB] pb-2">Data Pribadi</h4>
                                    
                                    <x-input-text wire:model="formData.nik" label="NIK" placeholder="Masukkan NIK"
                                        class="border-gray-300 rounded-md shadow-sm" required />
                                    
                                    <x-input-text wire:model="formData.no_kk_id" label="No. KK" placeholder="Masukkan No. KK"
                                        class="border-gray-300 rounded-md shadow-sm" required />
                                    
                                    <x-input-text wire:model="formData.nama" label="Nama Lengkap" placeholder="Masukkan nama lengkap"
                                        class="border-gray-300 rounded-md shadow-sm" required />
                                    
                                    <x-input-text wire:model="formData.tempat_lahir" label="Tempat Lahir" placeholder="Masukkan tempat lahir"
                                        class="border-gray-300 rounded-md shadow-sm" required />
                                    
                                    <x-input-date wire:model="formData.tanggal_lahir" label="Tanggal Lahir"
                                        class="border-gray-300 rounded-md shadow-sm" required />
                                    
                                    <x-input-select wire:model="formData.jenis_kelamin" label="Jenis Kelamin"
                                        placeholder="Pilih jenis kelamin"
                                        :options="[['value' => 'LAKI-LAKI', 'label' => 'Laki-laki'], ['value' => 'PEREMPUAN', 'label' => 'Perempuan']]"
                                        class="border-gray-300 rounded-md shadow-sm" required />
                                </div>

                                <!-- Data Alamat & Lainnya -->
                                <div class="space-y-4">
                                    <h4 class="font-medium text-[#4E347E] border-b border-[#ADC4DB] pb-2">Data Identitas</h4>
                                    
                                    <x-input-select wire:model="formData.golongan_darah" label="Golongan Darah"
                                        placeholder="Pilih golongan darah"
                                        :options="[
                                            ['value' => 'A', 'label' => 'A'],
                                            ['value' => 'B', 'label' => 'B'],
                                            ['value' => 'AB', 'label' => 'AB'],
                                            ['value' => 'O', 'label' => 'O']
                                        ]"
                                        class="border-gray-300 rounded-md shadow-sm" required />
                                    
                                    <x-input-select wire:model="formData.agama_id" label="Agama"
                                        placeholder="Pilih agama"
                                        :options="[
                                            ['value' => '1', 'label' => 'Islam'],
                                            ['value' => '2', 'label' => 'Kristen'],
                                            ['value' => '3', 'label' => 'Katolik'],
                                            ['value' => '4', 'label' => 'Hindu'],
                                            ['value' => '5', 'label' => 'Buddha'],
                                            ['value' => '6', 'label' => 'Konghucu']
                                        ]"
                                        class="border-gray-300 rounded-md shadow-sm" required />
                                    
                                    <x-input-select wire:model="formData.status_perkawinan" label="Status Pernikahan"
                                        placeholder="Pilih status pernikahan"
                                        :options="[
                                            ['value' => 'Belum Kawin', 'label' => 'Belum Kawin'],
                                            ['value' => 'Kawin', 'label' => 'Kawin'],
                                            ['value' => 'Cerai Hidup', 'label' => 'Cerai Hidup'],
                                            ['value' => 'Cerai Mati', 'label' => 'Cerai Mati']
                                        ]"
                                        class="border-gray-300 rounded-md shadow-sm" required />
                                    
                                    <x-input-select wire:model="formData.pendidikan_terakhir_id" label="Pendidikan Terakhir"
                                        placeholder="Pilih pendidikan terakhir"
                                        :options="[
                                            ['value' => '1', 'label' => 'Tidak/Belum Sekolah'],
                                            ['value' => '2', 'label' => 'SD'],
                                            ['value' => '3', 'label' => 'SMP'],
                                            ['value' => '4', 'label' => 'SMA'],
                                            ['value' => '5', 'label' => 'D3'],
                                            ['value' => '6', 'label' => 'S1'],
                                            ['value' => '7', 'label' => 'S2'],
                                            ['value' => '8', 'label' => 'S3']
                                        ]"
                                        class="border-gray-300 rounded-md shadow-sm" required />
                                    
                                    <x-input-select wire:model="formData.pekerjaan_id" label="Pekerjaan"
                                        placeholder="Pilih pekerjaan"
                                        :options="[
                                            ['value' => '1', 'label' => 'PNS'],
                                            ['value' => '2', 'label' => 'Guru'],
                                            ['value' => '3', 'label' => 'Mahasiswa'],
                                            ['value' => '4', 'label' => 'Pelajar'],
                                            ['value' => '5', 'label' => 'Petani'],
                                            ['value' => '6', 'label' => 'Wirausaha'],
                                            ['value' => '7', 'label' => 'Tidak Bekerja']
                                        ]"
                                        class="border-gray-300 rounded-md shadow-sm" />
                                    
                                    <x-input-select wire:model="formData.kewarganegaraan" label="Kewarganegaraan"
                                        :options="[
                                            ['value' => 'WNI', 'label' => 'Warga Negara Indonesia'],
                                            ['value' => 'WNA', 'label' => 'Warga Negara Asing']
                                        ]"
                                        class="border-gray-300 rounded-md shadow-sm" required />

                                    <!-- Dokumen Imigrasi (kondisional untuk WNA) -->
                                    @if(($formData['kewarganegaraan'] ?? '') === 'WNA')
                                        <x-input-text wire:model="formData.no_paspor" label="No. Paspor" 
                                            placeholder="Masukkan nomor paspor"
                                            class="border-gray-300 rounded-md shadow-sm" />
                                        
                                        <x-input-text wire:model="formData.no_kitap" label="No. KITAP" 
                                            placeholder="Masukkan nomor KITAP"
                                            class="border-gray-300 rounded-md shadow-sm" />
                                    @endif
                                </div>
                            </div>

                            <!-- Data KK & Keluarga -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                                <div class="space-y-4">
                                    <h4 class="font-medium text-[#4E347E] border-b border-[#ADC4DB] pb-2">Data Kartu Keluarga</h4>
                                    
                                    <x-input-select wire:model="formData.hubungan_keluarga_id" label="Hubungan Dalam KK"
                                        placeholder="Pilih hubungan dalam KK"
                                        :options="[
                                            ['value' => '1', 'label' => 'Kepala Keluarga'],
                                            ['value' => '2', 'label' => 'Suami'],
                                            ['value' => '3', 'label' => 'Istri'],
                                            ['value' => '4', 'label' => 'Anak'],
                                            ['value' => '5', 'label' => 'Menantu'],
                                            ['value' => '6', 'label' => 'Cucu'],
                                            ['value' => '7', 'label' => 'Orangtua'],
                                            ['value' => '8', 'label' => 'Mertua'],
                                            ['value' => '9', 'label' => 'Famili Lain'],
                                            ['value' => '10', 'label' => 'Pembantu'],
                                            ['value' => '11', 'label' => 'Lainnya']
                                        ]"
                                        class="border-gray-300 rounded-md shadow-sm" required />
                                </div>

                                <div class="space-y-4">
                                    <h4 class="font-medium text-[#4E347E] border-b border-[#ADC4DB] pb-2">Data Orangtua</h4>
                                    
                                    <x-input-text wire:model="formData.nama_ayah" label="Nama Ayah" 
                                        placeholder="Masukkan nama ayah"
                                        class="border-gray-300 rounded-md shadow-sm" required />
                                    
                                    <x-input-text wire:model="formData.nama_ibu" label="Nama Ibu" 
                                        placeholder="Masukkan nama ibu"
                                        class="border-gray-300 rounded-md shadow-sm" required />
                                </div>
                            </div>

                            <!-- Data Pernikahan & Status -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                                <div class="space-y-4">
                                    <h4 class="font-medium text-[#4E347E] border-b border-[#ADC4DB] pb-2">Data Pernikahan</h4>
                                    
                                    <!-- Tanggal Perkawinan (kondisional) -->
                                    @if(($formData['status_perkawinan'] ?? '') === 'Kawin')
                                        <x-input-date wire:model="formData.tanggal_perkawinan" label="Tanggal Perkawinan"
                                            class="border-gray-300 rounded-md shadow-sm" />
                                    @endif
                                    
                                    <!-- Tanggal Perceraian (kondisional) -->
                                    @if(in_array($formData['status_perkawinan'], ['Cerai Hidup', 'Cerai Mati']))
                                        <x-input-date wire:model="formData.tanggal_perceraian" label="Tanggal Perceraian"
                                            class="border-gray-300 rounded-md shadow-sm" />
                                    @endif
                                </div>

                                <div class="space-y-4">
                                    <h4 class="font-medium text-[#4E347E] border-b border-[#ADC4DB] pb-2">Status Khusus</h4>
                                    
                                    <!-- Penyandang Disabilitas -->
                                    <div class="space-y-2">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" wire:model.live="formData.penyandang_disabilitas"
                                                class="form-checkbox h-5 w-5 text-[#376CB4] rounded focus:ring-[#376CB4] border-gray-300">
                                            <span class="ml-2 text-sm font-medium text-gray-700">Penyandang Disabilitas</span>
                                        </label>
                                    </div>

                                    <!-- Detail Disabilitas (kondisional) -->
                                    @if($formData['penyandang_disabilitas'] ?? false)
                                        <x-input-text wire:model="formData.detail_disabilitas" label="Detail Disabilitas" 
                                            placeholder="Masukkan detail disabilitas"
                                            class="border-gray-300 rounded-md shadow-sm" />
                                    @endif
                                </div>
                            </div>

                            <!-- Modal Footer -->
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse mt-6 -mx-6 -mb-4">
                                <x-button type="submit" variant="primary"
                                    class="w-full sm:w-auto sm:ml-3 bg-[#376CB4] hover:bg-[#457BC5] text-white">
                                    <x-heroicon-o-check class="h-5 w-5 mr-2" />
                                    Simpan Data
                                </x-button>
                                <x-button wire:click="closeTambahModal" type="button" variant="secondary"
                                    class="mt-3 sm:mt-0 w-full sm:w-auto bg-gray-200 hover:bg-gray-300 text-gray-700">
                                    <x-heroicon-o-x-mark class="h-5 w-5 mr-2" />
                                    Batal
                                </x-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endauth
</div>