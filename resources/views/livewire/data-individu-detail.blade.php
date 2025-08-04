<div>
    <div class="mb-4">
        <a href="{{ route('data-warga.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-800">
            <x-heroicon-o-arrow-left class="h-5 w-5 mr-2" />
            Detail Data Warga:
        </a>
    </div>

    <x-card class="bg-white rounded-xl shadow-lg p-6 border border-gray-200">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="text-3xl font-bold text-gray-800 mb-2">{{ $resident->nama }}</h2>
                @auth
                    <p class="text-gray-600 font-mono text-lg">NIK: {{ $resident->nik}}</p>
                    @else
                    <p class="text-gray-600 font-mono text-lg">NIK: {{ substr($resident->nik, 0, -6) . '******' }}</p>
                @endauth
            </div>
            <div class="flex flex-col items-end gap-3">
                <div class="flex space-x-2">
                    <!-- Replace the existing edit button with this one -->
                    <button wire:click="editData" type="button"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-all duration-200 text-sm font-medium">
                        <x-heroicon-o-pencil class="h-4 w-4 mr-2" />
                        Edit Data
                    </button>
                    <button onclick="confirmDelete()" type="button"
                        class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-all duration-200 text-sm font-medium">
                        <x-heroicon-o-trash class="h-4 w-4 mr-2" />
                        Hapus Data
                    </button>
                </div>
                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-[#C5B6E1] text-[#4E347E]">
                    Status: Hidup
                </span>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="mb-4 p-4 rounded-lg bg-green-100 border border-green-400 text-green-700">
                <div class="flex items-center">
                    <x-heroicon-o-check-circle class="h-5 w-5 mr-2" />
                    {{ session('message') }}
                </div>
            </div>
        @endif

        <!-- Informasi Pribadi -->
        <div>
            <h3 class="text-xl font-bold text-[#4E347E] mb-6">Informasi Pribadi</h3>
            
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                <!-- Informasi Dasar -->
                <div>
                    <h4 class="text-lg font-semibold text-gray-700 mb-4 bg-gradient-to-r from-gray-50 to-gray-100 p-3 rounded border border-gray-200">Informasi Dasar</h4>
                    <div class="bg-white border border-gray-300 rounded-lg overflow-hidden shadow-sm">
                        <div class="divide-y divide-gray-200">
                            <div class="p-4 hover:bg-gray-50 transition-colors duration-150 flex">
                                <span class="font-medium text-gray-600 text-sm w-40">Nomor KK:</span>
                                @auth
                                    <div class="text-gray-900 font-mono text-sm">{{ $resident->no_kk_id }}</div>
                                    @else
                                    <div class="text-gray-900 font-mono text-sm">{{ substr($resident->no_kk_id, 0, -6) . '******' }}</div>
                                @endauth
                            </div>
                            <div class="p-4 hover:bg-gray-50 transition-colors duration-150 flex">
                                <span class="font-medium text-gray-600 text-sm w-40">Nomor NIK:</span>
                                @auth
                                    <div class="text-gray-900 font-mono text-sm">{{ $resident->nik }}</div>
                                    @else
                                    <div class="text-gray-900 font-mono text-sm">{{ substr($resident->nik, 0, -6) . '******' }}</div>
                                @endauth
                            </div>
                            <div class="p-4 hover:bg-gray-50 transition-colors duration-150 flex">
                                <span class="font-medium text-gray-600 text-sm w-40">Nama Lengkap:</span>
                                <div class="text-gray-900 font-medium text-sm">{{ $resident->nama }}</div>
                            </div>
                            <div class="p-4 hover:bg-gray-50 transition-colors duration-150 flex">
                                <span class="font-medium text-gray-600 text-sm w-40">Tempat, Tanggal Lahir:</span>
                                <div class="text-gray-900 text-sm">{{ $resident->tempat_lahir }}, {{ \Carbon\Carbon::parse($resident->tanggal_lahir)->format('d F Y') }}</div>
                            </div>
                            <div class="p-4 hover:bg-gray-50 transition-colors duration-150 flex">
                                <span class="font-medium text-gray-600 text-sm w-40">Usia:</span>
                                <div class="text-gray-900 text-sm">{{ \Carbon\Carbon::parse($resident->tanggal_lahir)->age }} Tahun</div>
                            </div>
                            <div class="p-4 hover:bg-gray-50 transition-colors duration-150 flex">
                                <span class="font-medium text-gray-600 text-sm w-40">Pendidikan Terakhir:</span>
                                <div class="text-gray-900 text-sm">{{ $resident->pendidikanTerakhir->nama ?? 'ID: ' . $resident->pendidikan_terakhir_id }}</div>
                            </div>
                            <div class="p-4 hover:bg-gray-50 transition-colors duration-150 flex">
                                <span class="font-medium text-gray-600 text-sm w-40">Gol Darah:</span>
                                <div class="text-gray-900 text-sm">{{ $resident->golongan_darah === '-' ? '-' : $resident->golongan_darah }}</div>
                            </div>
                            <div class="p-4 hover:bg-gray-50 transition-colors duration-150 flex">
                                <span class="font-medium text-gray-600 text-sm w-40">Agama:</span>
                                <div class="text-gray-900 text-sm">{{ $resident->agama->nama ?? 'ID: ' . $resident->agama_id }}</div>
                            </div>
                            <div class="p-4 hover:bg-gray-50 transition-colors duration-150 flex">
                                <span class="font-medium text-gray-600 text-sm w-40">Status Pernikahan:</span>
                                <div class="text-gray-900 text-sm">{{ $resident->status_perkawinan }}</div>
                            </div>
                            @if($resident->status_perkawinan === 'Kawin' && isset($resident->tanggal_perkawinan))
                            <div class="p-4 hover:bg-gray-50 transition-colors duration-150 flex">
                                <span class="font-medium text-gray-600 text-sm w-40">Tanggal Perkawinan:</span>
                                <div class="text-gray-900 text-sm">{{ \Carbon\Carbon::parse($resident->tanggal_perkawinan)->format('d F Y') }}</div>
                            </div>
                            @elseif(in_array($resident->status_perkawinan, ['Cerai Hidup', 'Cerai Mati']) && isset($resident->tanggal_perceraian))
                            <div class="p-4 hover:bg-gray-50 transition-colors duration-150 flex">
                                <span class="font-medium text-gray-600 text-sm w-40">Tanggal Cerai:</span>
                                <div class="text-gray-900 text-sm">{{ \Carbon\Carbon::parse($resident->tanggal_perceraian)->format('d F Y') }}</div>
                            </div>
                            @endif
                            <div class="p-4 hover:bg-gray-50 transition-colors duration-150 flex">
                                <span class="font-medium text-gray-600 text-sm w-40">Pekerjaan:</span>
                                <div class="text-gray-900 text-sm">{{ $resident->pekerjaan->nama ?? 'ID: ' . $resident->pekerjaan_id }}</div>
                            </div>
                            <div class="p-4 hover:bg-gray-50 transition-colors duration-150 flex">
                                <span class="font-medium text-gray-600 text-sm w-40">Kewarganegaraan:</span>
                                <div class="text-gray-900 text-sm">
                                    @if($resident->kewarganegaraan === 'WNI')
                                        <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-green-50 text-green-700 border border-green-200">
                                            🇮🇩 Warga Negara Indonesia
                                        </span>
                                    @elseif($resident->kewarganegaraan === 'WNA')
                                        <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-blue-50 text-blue-700 border border-blue-200">
                                            🌍 Warga Negara Asing
                                        </span>
                                    @else
                                        {{ $resident->kewarganegaraan }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Keluarga dalam Kartu Keluarga -->
                <div>
                    <h4 class="text-lg font-semibold text-gray-700 mb-4 bg-gradient-to-r from-gray-50 to-gray-100 p-3 rounded border border-gray-200">Keluarga dalam Kartu Keluarga</h4>
                    
                    <!-- Informasi Orang Tua -->
                    <div class="mb-6">
                        <h5 class="text-sm font-semibold text-gray-600 mb-3 px-1">Informasi Orang Tua</h5>
                        <div class="bg-white rounded-lg border border-gray-300 overflow-hidden shadow-sm">
                            <table class="min-w-full">
                                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                    <tr>
                                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wide border-b border-gray-200">Hubungan</th>
                                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wide border-b border-gray-200">Nama</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-3 py-3 text-xs text-gray-900 font-medium">Ayah</td>
                                        <td class="px-3 py-3 text-xs text-gray-900">{{ $resident->nama_ayah ?? '-' }}</td>
                                    </tr>
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-3 py-3 text-xs text-gray-900 font-medium">Ibu</td>
                                        <td class="px-3 py-3 text-xs text-gray-900">{{ $resident->nama_ibu ?? '-' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Anggota Keluarga dalam KK -->
                    <div>
                        <h5 class="text-sm font-semibold text-gray-600 mb-3 px-1">Anggota Keluarga dalam KK</h5>
                        <div class="bg-white rounded-lg border border-gray-300 overflow-hidden shadow-sm">
                            <table class="min-w-full">
                                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                    <tr>
                                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wide border-b border-gray-200">Hubungan</th>
                                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wide border-b border-gray-200">Nama</th>
                                        <th class="px-3 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wide border-b border-gray-200">NIK</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @if(isset($resident->keluarga_dalam_kk) && !empty($resident->keluarga_dalam_kk))
                                        @foreach($resident->keluarga_dalam_kk as $keluarga)
                                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                <td class="px-3 py-3 text-xs text-gray-900">{{ $keluarga->hubungan }}</td>
                                                <td class="px-3 py-3 text-xs text-gray-900">{{ $keluarga->nama_anggota }}</td>
                                                @auth
                                                    <td class="px-3 py-3 text-xs font-mono text-gray-600">{{ $keluarga->nik }}</td>
                                                @else
                                                    <td class="px-3 py-3 text-xs font-mono text-gray-600">{{ substr($keluarga->nik, 0, -6) . '******' }}</td>
                                                @endauth
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        @if(isset($resident->keluarga_dalam_kk) && empty($resident->keluarga_dalam_kk))
                            <div class="text-center py-6">
                                <x-heroicon-o-user-group class="h-8 w-8 text-gray-400 mx-auto mb-2" />
                                <span class="text-sm text-gray-500">Data keluarga tidak tersedia</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Informasi Tambahan -->
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 mt-8">
                <!-- Dokumen & Alamat -->
                <div>
                    <h4 class="text-lg font-semibold text-gray-700 mb-4 bg-gradient-to-r from-gray-50 to-gray-100 p-3 rounded border border-gray-200">Dokumen & Alamat</h4>
                    <div class="bg-white border border-gray-300 rounded-lg overflow-hidden shadow-sm">
                        <div class="divide-y divide-gray-200">
                            @if(isset($resident->no_paspor) && !empty($resident->no_paspor))
                            <div class="p-4 hover:bg-gray-50 transition-colors duration-150 flex">
                                <span class="font-medium text-gray-600 text-sm w-40">No. Paspor:</span>
                                <div class="text-gray-900 font-mono text-sm">{{ $resident->no_paspor }}</div>
                            </div>
                            @endif
                            @if(isset($resident->no_kitap) && !empty($resident->no_kitap))
                            <div class="p-4 hover:bg-gray-50 transition-colors duration-150 flex">
                                <span class="font-medium text-gray-600 text-sm w-40">No. KITAP:</span>
                                <div class="text-gray-900 font-mono text-sm">{{ $resident->no_kitap }}</div>
                            </div>
                            @endif
                            <div class="p-4 hover:bg-gray-50 transition-colors duration-150 flex">
                                <span class="font-medium text-gray-600 text-sm w-40">RT:</span>
                                <div class="text-gray-900 text-sm">{{ $resident->dataKeluarga->rt }}</div>
                            </div>
                            <div class="p-4 hover:bg-gray-50 transition-colors duration-150 flex">
                                <span class="font-medium text-gray-600 text-sm w-40">RW:</span>
                                <div class="text-gray-900 text-sm">{{ $resident->dataKeluarga->rw }}</div>
                            </div>
                            <div class="p-4 hover:bg-gray-50 transition-colors duration-150 flex">
                                <span class="font-medium text-gray-600 text-sm w-40">Alamat Lengkap:</span>
                                <div class="text-gray-900 text-sm">{{ $resident->dataKeluarga->alamat }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Khusus -->
                <div>
                    <h4 class="text-lg font-semibold text-gray-700 mb-4 bg-gradient-to-r from-gray-50 to-gray-100 p-3 rounded border border-gray-200">Status Khusus</h4>
                    <div class="bg-white border border-gray-300 rounded-lg overflow-hidden shadow-sm">
                        <div class="divide-y divide-gray-200">
                            <div class="p-4 hover:bg-gray-50 transition-colors duration-150 flex">
                                <span class="font-medium text-gray-600 text-sm w-40">Penyandang Disabilitas:</span>
                                <div class="text-gray-900 text-sm">{{ $resident->penyandang_disabilitas ? 'Ya' : 'Tidak' }}</div>
                            </div>
                            @if(isset($resident->penyandang_disabilitas) && !empty($resident->penyandang_disabilitas))
                            <div class="p-4 hover:bg-gray-50 transition-colors duration-150 flex">
                                <span class="font-medium text-gray-600 text-sm w-40">Detail Disabilitas:</span>
                                <div class="text-gray-900 text-sm">{{ $resident->penyandang_disabilitas }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-card>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 max-w-md mx-4 shadow-2xl">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                    <x-heroicon-o-exclamation-triangle class="h-6 w-6 text-red-600" />
                </div>
                <h3 class="text-lg font-semibold text-gray-900">Konfirmasi Hapus Data</h3>
            </div>
            <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus data warga ini? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="flex space-x-3 justify-end">
                <button onclick="closeDeleteModal()" type="button"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-all duration-200 text-sm font-medium">
                    Batal
                </button>
                <button onclick="confirmDeleteAction()" type="button"
                    class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-all duration-200 text-sm font-medium">
                    Hapus Data
                </button>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    @auth
        @if($showEditModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" id="editModal" aria-labelledby="edit-modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeEditModal"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="edit-modal-title">
                                Edit Data Warga: {{ $editFormData['nama'] ?? '' }}
                            </h3>
                            <button type="button" wire:click="closeEditModal"
                                class="text-gray-400 hover:text-gray-600 transition-colors">
                                <x-heroicon-o-x-mark class="h-6 w-6" />
                            </button>
                        </div>

                        <form wire:submit.prevent="updateDataWarga" class="space-y-6">
                            <!-- Data Identitas -->
                            <div class="space-y-4">
                                <h4 class="text-md font-semibold text-gray-800 border-b pb-2">Data Identitas</h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <x-input-text wire:model="editFormData.nik" label="NIK" 
                                        placeholder="Masukkan 16 digit NIK"
                                        class="border-gray-300 rounded-md shadow-sm" required />
                                        @error('editFormData.nik')
                                            <span class="text-red-600 text-xs">{{ $message }}</span>
                                        @enderror
                                    <div class="space-y-0">
                                    <label class="block text-sm font-medium text-gray-700">No. KK *</label>
                                    <div class="flex gap-2">
                                        <x-input-text wire:model="editFormData.no_kk_id" 
                                            placeholder="Masukkan 16 digit No. KK"
                                            class="border-gray-300 rounded-md shadow-sm flex-1" required />
                                            @error('editFormData.no_kk_id')
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
                                        <div class="flex items-center text-sm text-green-600 mt-1">
                                            <x-heroicon-o-check-circle class="h-4 w-4 mr-2" />
                                            No. KK ditemukan dalam database
                                        </div>
                                    @elseif($kkExists === false)
                                        <div class="flex items-center text-sm text-orange-600 mt-1">
                                            <x-heroicon-o-exclamation-triangle class="h-4 w-4 mr-2" />
                                            No. KK belum terdaftar - silakan isi data KK di bawah
                                        </div>
                                    @endif
                                </div>
                                </div>
                            </div>

                            <!-- Data Kartu Keluarga (shown only when KK doesn't exist) -->
                            @if($kkExists === false)
                            <div class="space-y-4">
                                <h4 class="text-md font-semibold text-gray-800 border-b pb-2">Data Kartu Keluarga</h4>
                                
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
                                    <x-input-text wire:model="editFormData.nama" label="Nama Lengkap" 
                                        placeholder="Masukkan nama lengkap sesuai KTP"
                                        class="border-gray-300 rounded-md shadow-sm" required />
                                        @error('editFormData.nama')
                                            <span class="text-red-600 text-xs">{{ $message }}</span>
                                        @enderror
                                    <x-input-text wire:model="editFormData.tempat_lahir" label="Tempat Lahir" 
                                        placeholder="Masukkan tempat lahir"
                                        class="border-gray-300 rounded-md shadow-sm" required />
                                        @error('editFormData.tempat_lahir')
                                            <span class="text-red-600 text-xs">{{ $message }}</span>
                                        @enderror
                                    <x-input-date wire:model="editFormData.tanggal_lahir" label="Tanggal Lahir"
                                        class="border-gray-300 rounded-md shadow-sm" required />
                                        @error('editFormData.tanggal_lahir')
                                            <span class="text-red-600 text-xs">{{ $message }}</span>
                                        @enderror
                                    <x-input-select wire:model="editFormData.jenis_kelamin" label="Jenis Kelamin"
                                        placeholder="Pilih jenis kelamin"
                                        :options="[
                                            ['value' => 'LAKI-LAKI', 'label' => 'Laki-laki'],
                                            ['value' => 'PEREMPUAN', 'label' => 'Perempuan']
                                        ]"
                                        class="border-gray-300 rounded-md shadow-sm" required />
                                        @error('editFormData.jenis_kelamin')
                                            <span class="text-red-600 text-xs">{{ $message }}</span>
                                        @enderror
                                    <x-input-select wire:model="editFormData.golongan_darah" label="Golongan Darah"
                                        placeholder="Pilih golongan darah"
                                        :options="[
                                            ['value' => 'A', 'label' => 'A'],
                                            ['value' => 'B', 'label' => 'B'],
                                            ['value' => 'AB', 'label' => 'AB'],
                                            ['value' => 'O', 'label' => 'O']
                                        ]"
                                        class="border-gray-300 rounded-md shadow-sm" />
                                        @error('editFormData.golongan_darah')
                                            <span class="text-red-600 text-xs">{{ $message }}</span>
                                        @enderror
                                    <x-input-select wire:model="editFormData.agama_id" label="Agama"
                                        placeholder="Pilih agama"
                                        :options="$agamaOptions ?? []"
                                        class="border-gray-300 rounded-md shadow-sm" required />
                                        @error('editFormData.agama_id')
                                            <span class="text-red-600 text-xs">{{ $message }}</span>
                                        @enderror
                                </div>
                            </div>

                            <!-- Data Pernikahan -->
                            <div class="space-y-4">
                                <h4 class="text-md font-semibold text-gray-800 border-b pb-2">Data Pernikahan</h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <x-input-select wire:model.live="editFormData.status_perkawinan" label="Status Pernikahan"
                                        placeholder="Pilih status pernikahan"
                                        :options="[
                                            ['value' => 'Belum Kawin', 'label' => 'Belum Kawin'],
                                            ['value' => 'Kawin', 'label' => 'Kawin'],
                                            ['value' => 'Cerai Hidup', 'label' => 'Cerai Hidup'],
                                            ['value' => 'Cerai Mati', 'label' => 'Cerai Mati']
                                        ]"
                                        class="border-gray-300 rounded-md shadow-sm"
                                        required />
                                        @error('editFormData.status_perkawinan')
                                            <span class="text-red-600 text-xs">{{ $message }}</span>
                                        @enderror

                                    @if(in_array($editFormData['status_perkawinan'] ?? '', ['Kawin', 'Cerai Hidup', 'Cerai Mati']))
                                        <x-input-date wire:model="editFormData.tanggal_perkawinan" label="Tanggal Perkawinan"
                                        class="border-gray-300 rounded-md shadow-sm" />
                                        @error('editFormData.tanggal_perkawinan')
                                            <span class="text-red-600 text-xs">{{ $message }}</span>
                                        @enderror
                                    @endif

                                    @if(in_array($editFormData['status_perkawinan'] ?? '', ['Cerai Hidup', 'Cerai Mati']))
                                        <x-input-date wire:model="editFormData.tanggal_perceraian" label="Tanggal Perceraian"
                                            class="border-gray-300 rounded-md shadow-sm" />
                                    @endif
                                </div>
                            </div>

                            <!-- Data Dokumen Imigrasi -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                                <div class="space-y-4">
                                    <h4 class="font-medium text-[#4E347E] border-b border-[#ADC4DB] pb-2">Dokumen Imigrasi (Opsional)</h4>
                                    
                                    <x-input-text wire:model="editFormData.no_paspor" label="No. Paspor" 
                                        placeholder="Masukkan nomor paspor (jika ada)"
                                        class="border-gray-300 rounded-md shadow-sm" />
                                    
                                    <x-input-text wire:model="editFormData.no_kitap" label="No. KITAP" 
                                        placeholder="Masukkan nomor KITAP"
                                        class="border-gray-300 rounded-md shadow-sm" />
                                </div>

                                <div class="space-y-4">
                                    <h4 class="font-medium text-[#4E347E] border-b border-[#ADC4DB] pb-2">&nbsp;</h4>
                                    <div class="text-sm text-gray-600 space-y-2">
                                        <p class="italic">* Dokumen imigrasi bersifat opsional dan hanya perlu diisi jika tersedia</p>
                                        @if(($editFormData['kewarganegaraan'] ?? '') === 'WNA')
                                            <p class="text-blue-600 font-medium">📋 KITAP diperlukan untuk Warga Negara Asing</p>
                                        @elseif(($editFormData['kewarganegaraan'] ?? '') === 'WNI')
                                            <p class="text-green-600 font-medium">🇮🇩 KITAP tidak diperlukan untuk Warga Negara Indonesia</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Data Pendidikan dan Pekerjaan -->
                            <div class="space-y-4">
                                <h4 class="text-md font-semibold text-gray-800 border-b pb-2">Pendidikan & Pekerjaan</h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <x-input-select wire:model="editFormData.pendidikan_terakhir_id" label="Pendidikan Terakhir"
                                        placeholder="Pilih pendidikan terakhir"
                                        :options="$pendidikanOptions ?? []"
                                        class="border-gray-300 rounded-md shadow-sm" required />

                                    <x-input-select wire:model="editFormData.pekerjaan_id" label="Pekerjaan"
                                        placeholder="Pilih pekerjaan"
                                        :options="$pekerjaanOptions ?? []"
                                        class="border-gray-300 rounded-md shadow-sm" required />
                                </div>
                            </div>

                            <!-- Data Keluarga -->
                            <div class="space-y-4">
                                <h4 class="text-md font-semibold text-gray-800 border-b pb-2">Data Keluarga</h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <x-input-select wire:model="editFormData.hubungan_keluarga_id" label="Hubungan dalam Keluarga"
                                        placeholder="Pilih hubungan keluarga"
                                        :options="$hubunganKeluargaOptions ?? []"
                                        class="border-gray-300 rounded-md shadow-sm" required />

                                    <x-input-select wire:model="editFormData.kewarganegaraan" label="Kewarganegaraan"
                                        placeholder="Pilih kewarganegaraan"
                                        :options="[
                                            ['value' => 'WNI', 'label' => 'WNI'],
                                            ['value' => 'WNA', 'label' => 'WNA']
                                        ]"
                                        class="border-gray-300 rounded-md shadow-sm" required />

                                    <x-input-text wire:model="editFormData.nama_ayah" label="Nama Ayah" 
                                        placeholder="Masukkan nama ayah"
                                        class="border-gray-300 rounded-md shadow-sm" />

                                    <x-input-text wire:model="editFormData.nama_ibu" label="Nama Ibu" 
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
                                            <input type="checkbox" wire:model.live="editFormData.penyandang_disabilitas_check"
                                                class="form-checkbox h-5 w-5 text-[#376CB4] rounded focus:ring-[#376CB4] border-gray-300">
                                            <span class="ml-2 text-sm font-medium text-gray-700">Penyandang Disabilitas</span>
                                        </label>
                                        
                                        @if($editFormData['penyandang_disabilitas_check'] ?? false)
                                            <x-input-text wire:model="editFormData.penyandang_disabilitas" label="Detail Disabilitas" 
                                                placeholder="Jelaskan jenis disabilitas"
                                                class="border-gray-300 rounded-md shadow-sm mt-2" />
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Footer Modal -->
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t">
                                <x-button type="submit" variant="primary"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-[#376CB4] text-base font-medium text-white hover:bg-[#457BC5] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#376CB4] sm:ml-3 sm:w-auto sm:text-sm">
                                    Simpan Perubahan
                                </x-button>
                                <x-button wire:click="closeEditModal" type="button" variant="secondary"
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

    <script>
    function confirmDelete() {
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteModal').classList.add('flex');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.getElementById('deleteModal').classList.remove('flex');
    }

    function confirmDeleteAction() {
        @this.call('hapusData');
        closeDeleteModal();
    }
    </script>
</div>
