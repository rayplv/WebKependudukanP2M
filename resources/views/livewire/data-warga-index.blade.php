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
    </x-card>

        <div class="mt-4">
            {{ $dataWarga->links() }}
        </div>

    <!-- Modal Tambah Data Warga - Gunakan wire:ignore untuk mencegah re-render -->
        @auth
        @if($showTambahModal)
        <div wire:ignore.self class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeTambahModal"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Tambah Data Warga Baru
                            </h3>
                            <button type="button" wire:click="closeTambahModal"
                                class="text-gray-400 hover:text-gray-600 transition-colors">
                                <x-heroicon-o-x-mark class="h-6 w-6" />
                            </button>
                        </div>

                        <form wire:submit.prevent="simpanDataWarga" class="space-y-6">
                            <!-- Data Identitas -->
                            <div class="space-y-4">
                                <h4 class="text-md font-semibold text-gray-800 border-b pb-2">Data Identitas</h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <x-input-text wire:model="formData.nik" label="NIK" 
                                        placeholder="Masukkan 16 digit NIK"
                                        class="border-gray-300 rounded-md shadow-sm" required />
                                        @error('formData.nik')
                                            <span class="text-red-600 text-xs">{{ $message }}</span>
                                        @enderror
                                    <div class="space-y-0">
                                        <label class="block text-sm font-medium text-gray-700">No. KK *</label>
                                        <div class="flex gap-2">
                                            <x-input-text wire:model="formData.no_kk_id" 
                                                placeholder="Masukkan 16 digit No. KK"
                                                class="border-gray-300 rounded-md shadow-sm flex-1" required />
                                                @error('formData.no_kk_id')
                                                    <span class="text-red-600 text-xs">{{ $message }}</span>
                                                @enderror
                                            <x-button wire:click="checkKKExists" type="button" variant="secondary"
                                                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md whitespace-nowrap"
                                                :disabled="$checkingKK">
                                                @if($checkingKK)
                                                    <x-heroicon-o-arrow-path class="h-4 w-4 animate-spin" />
                                                @else
                                                    <x-heroicon-o-magnifying-glass class="h-4 w-4 mr-1" />
                                                    Cek
                                                @endif
                                            </x-button>
                                        </div>
                                        
                                        @if($kkExists === true)
                                            <div class="flex items-center text-sm text-green-600">
                                                <x-heroicon-o-check-circle class="h-4 w-4 mr-2" />
                                                No. KK ditemukan dalam database
                                            </div>
                                        @elseif($kkExists === false)
                                            <div class="flex items-center text-sm text-orange-600">
                                                <x-heroicon-o-exclamation-triangle class="h-4 w-4 mr-2" />
                                                No. KK belum terdaftar - silakan isi data KK di bawah
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Form Data KK Baru (tampil jika KK belum ada) -->
                            @if($kkExists === false)
                                <div class="bg-orange-50 border border-orange-200 rounded-lg p-4 space-y-4">
                                    <h4 class="font-medium text-orange-800 flex items-center">
                                        <x-heroicon-o-home class="h-5 w-5 mr-2" />
                                        Data Kartu Keluarga Baru
                                    </h4>
                                    
                                    <div class="grid grid-cols-1 gap-4">
                                        <x-input-text wire:model="kkData.alamat" label="Alamat Lengkap" 
                                            placeholder="Masukkan alamat lengkap sesuai KK"
                                            class="border-gray-300 rounded-md shadow-sm" 
                                            rows="3" required />
                                            @error('kkData.alamat')
                                                <span class="text-red-600 text-xs">{{ $message }}</span>
                                            @enderror
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <x-input-text wire:model="kkData.rt" label="RT" 
                                                placeholder="Contoh: 01"
                                                class="border-gray-300 rounded-md shadow-sm" />
                                            @error('kkData.rt')
                                                <span class="text-red-600 text-xs">{{ $message }}</span>
                                            @enderror
                                            <x-input-text wire:model="kkData.rw" label="RW" 
                                                placeholder="Contoh: 01"
                                                class="border-gray-300 rounded-md shadow-sm" />
                                            @error('kkData.rw')
                                                <span class="text-red-600 text-xs">{{ $message }}</span>
                                            @enderror
                                            <x-input-date wire:model="kkData.tanggal_dikeluarkan" label="Tanggal Dikeluarkan KK" 
                                                class="border-gray-300 rounded-md shadow-sm" />
                                            @error('kkData.tanggal_dikeluarkan')
                                                <span class="text-red-600 text-xs">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Data Pribadi -->
                            <div class="space-y-4">
                                <h4 class="text-md font-semibold text-gray-800 border-b pb-2">Data Pribadi</h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <x-input-text wire:model="formData.nama" label="Nama Lengkap" 
                                        placeholder="Masukkan nama lengkap sesuai KTP"
                                        class="border-gray-300 rounded-md shadow-sm" required />
                                        @error('formData.nama')
                                            <span class="text-red-600 text-xs">{{ $message }}</span>
                                        @enderror
                                    <x-input-text wire:model="formData.tempat_lahir" label="Tempat Lahir" 
                                        placeholder="Masukkan tempat lahir"
                                        class="border-gray-300 rounded-md shadow-sm" required />
                                        @error('formData.tempat_lahir')
                                            <span class="text-red-600 text-xs">{{ $message }}</span>
                                        @enderror
                                    <x-input-date wire:model="formData.tanggal_lahir" label="Tanggal Lahir"
                                        class="border-gray-300 rounded-md shadow-sm" required />
                                        @error('formData.tanggal_lahir')
                                            <span class="text-red-600 text-xs">{{ $message }}</span>
                                        @enderror
                                    <x-input-select wire:model="formData.jenis_kelamin" label="Jenis Kelamin"
                                        placeholder="Pilih jenis kelamin"
                                        :options="[
                                            ['value' => 'LAKI-LAKI', 'label' => 'Laki-laki'],
                                            ['value' => 'PEREMPUAN', 'label' => 'Perempuan']
                                        ]"
                                        class="border-gray-300 rounded-md shadow-sm" required />
                                        @error('formData.jenis_kelamin')
                                            <span class="text-red-600 text-xs">{{ $message }}</span>
                                        @enderror
                                    <x-input-select wire:model="formData.golongan_darah" label="Golongan Darah"
                                        placeholder="Pilih golongan darah"
                                        :options="[
                                            ['value' => 'A', 'label' => 'A'],
                                            ['value' => 'B', 'label' => 'B'],
                                            ['value' => 'AB', 'label' => 'AB'],
                                            ['value' => 'O', 'label' => 'O']
                                        ]"
                                        class="border-gray-300 rounded-md shadow-sm" />
                                        @error('formData.golongan_darah')
                                            <span class="text-red-600 text-xs">{{ $message }}</span>
                                        @enderror
                                    <x-input-select wire:model="formData.agama_id" label="Agama"
                                        placeholder="Pilih agama"
                                        :options="$agamaOptions ?? []"
                                        class="border-gray-300 rounded-md shadow-sm" required />
                                        @error('formData.agama_id')
                                            <span class="text-red-600 text-xs">{{ $message }}</span>
                                        @enderror
                                </div>
                            </div>

                            <!-- Data Pernikahan -->
                            <div class="space-y-4">
                                <h4 class="text-md font-semibold text-gray-800 border-b pb-2">Data Pernikahan</h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <x-input-select wire:model.live="formData.status_perkawinan" label="Status Pernikahan"
                                        placeholder="Pilih status pernikahan"
                                        :options="[
                                            ['value' => 'Belum Kawin', 'label' => 'Belum Kawin'],
                                            ['value' => 'Kawin', 'label' => 'Kawin'],
                                            ['value' => 'Cerai Hidup', 'label' => 'Cerai Hidup'],
                                            ['value' => 'Cerai Mati', 'label' => 'Cerai Mati']
                                        ]"
                                        class="border-gray-300 rounded-md shadow-sm"
                                        required />
                                        @error('formData.status_perkawinan')
                                            <span class="text-red-600 text-xs">{{ $message }}</span>
                                        @enderror

                                    @if(in_array($formData['status_perkawinan'] ?? '', ['Kawin', 'Cerai Hidup', 'Cerai Mati']))
                                        <x-input-date wire:model="formData.tanggal_perkawinan" label="Tanggal Perkawinan"
                                        class="border-gray-300 rounded-md shadow-sm" />
                                        @error('formData.tanggal_perkawinan')
                                            <span class="text-red-600 text-xs">{{ $message }}</span>
                                        @enderror
                                    @endif

                                    @if(in_array($formData['status_perkawinan'] ?? '', ['Cerai Hidup', 'Cerai Mati']))
                                        <x-input-date wire:model="formData.tanggal_perceraian" label="Tanggal Perceraian"
                                            class="border-gray-300 rounded-md shadow-sm" />
                                    @endif
                                </div>
                            </div>

                            <!-- Data Dokumen Imigrasi -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                                <div class="space-y-4">
                                    <h4 class="font-medium text-[#4E347E] border-b border-[#ADC4DB] pb-2">Dokumen Imigrasi (Opsional)</h4>
                                    
                                    <x-input-text wire:model="formData.no_paspor" label="No. Paspor" 
                                        placeholder="Masukkan nomor paspor (jika ada)"
                                        class="border-gray-300 rounded-md shadow-sm" />
                                    
                                    @if($formData['kewarganegaraan'] ?? '' === 'WNA')
                                        <x-input-text wire:model="formData.no_kitap" label="No. KITAP" 
                                            placeholder="Masukkan nomor KITAP"
                                            class="border-gray-300 rounded-md shadow-sm" />
                                    @endif
                                </div>

                                <div class="space-y-4">
                                    <h4 class="font-medium text-[#4E347E] border-b border-[#ADC4DB] pb-2">&nbsp;</h4>
                                    <div class="text-sm text-gray-600 space-y-2">
                                        <p class="italic">* Dokumen imigrasi bersifat opsional dan hanya perlu diisi jika tersedia</p>
                                        @if($formData['kewarganegaraan'] ?? '' === 'WNA')
                                            <p class="text-blue-600 font-medium">📋 KITAP diperlukan untuk Warga Negara Asing</p>
                                        @elseif($formData['kewarganegaraan'] ?? '' === 'WNI')
                                            <p class="text-green-600 font-medium">🇮🇩 KITAP tidak diperlukan untuk Warga Negara Indonesia</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Data Pendidikan dan Pekerjaan -->
                            <div class="space-y-4">
                                <h4 class="text-md font-semibold text-gray-800 border-b pb-2">Pendidikan & Pekerjaan</h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <x-input-select wire:model="formData.pendidikan_terakhir_id" label="Pendidikan Terakhir"
                                        placeholder="Pilih pendidikan terakhir"
                                        :options="$pendidikanOptions ?? []"
                                        class="border-gray-300 rounded-md shadow-sm" required />

                                    <x-input-select wire:model="formData.pekerjaan_id" label="Pekerjaan"
                                        placeholder="Pilih pekerjaan"
                                        :options="$pekerjaanOptions ?? []"
                                        class="border-gray-300 rounded-md shadow-sm" required />
                                </div>
                            </div>

                            <!-- Data Keluarga -->
                            <div class="space-y-4">
                                <h4 class="text-md font-semibold text-gray-800 border-b pb-2">Data Keluarga</h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <x-input-select wire:model="formData.hubungan_keluarga_id" label="Hubungan dalam Keluarga"
                                        placeholder="Pilih hubungan keluarga"
                                        :options="$hubunganKeluargaOptions ?? []"
                                        class="border-gray-300 rounded-md shadow-sm" required />

                                    <x-input-select wire:model="formData.kewarganegaraan" label="Kewarganegaraan"
                                        placeholder="Pilih kewarganegaraan"
                                        :options="[
                                            ['value' => 'WNI', 'label' => 'WNI'],
                                            ['value' => 'WNA', 'label' => 'WNA']
                                        ]"
                                        class="border-gray-300 rounded-md shadow-sm" required />

                                    <x-input-text wire:model="formData.nama_ayah" label="Nama Ayah" 
                                        placeholder="Masukkan nama ayah"
                                        class="border-gray-300 rounded-md shadow-sm" />

                                    <x-input-text wire:model="formData.nama_ibu" label="Nama Ibu" 
                                        placeholder="Masukkan nama ibu"
                                        class="border-gray-300 rounded-md shadow-sm" />
                                </div>
                            </div>

                            <!-- Data Tambahan -->
                            <div class="space-y-4">
                                <h4 class="text-md font-semibold text-gray-800 border-b pb-2">Data Tambahan</h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Penyandang Disabilitas -->
                                    <div class="space-y-2">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" wire:model.live="formData.penyandang_disabilitas_check"
                                                class="form-checkbox h-5 w-5 text-[#376CB4] rounded focus:ring-[#376CB4] border-gray-300">
                                            <span class="ml-2 text-sm font-medium text-gray-700">Penyandang Disabilitas</span>
                                        </label>
                                        
                                        @if($formData['penyandang_disabilitas_check'] ?? false)
                                            <x-input-text wire:model="formData.penyandang_disabilitas" label="Detail Disabilitas" 
                                                placeholder="Jelaskan jenis disabilitas"
                                                class="border-gray-300 rounded-md shadow-sm mt-2" />
                                        @endif
                                    </div>

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

                            <!-- Footer Modal -->
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t">
                                <x-button type="submit" variant="primary"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-[#376CB4] text-base font-medium text-white hover:bg-[#457BC5] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#376CB4] sm:ml-3 sm:w-auto sm:text-sm">
                                    Simpan Data Warga
                                </x-button>
                                <x-button wire:click="closeTambahModal" type="button" variant="secondary"
                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#376CB4] sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
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
