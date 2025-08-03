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
                <p class="text-gray-600 font-mono text-lg">NIK: {{ substr($resident->nik, 0, -6) . '******' }}</p>
            </div>
            <div class="flex flex-col items-end gap-3">
                <div class="flex space-x-2">
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
                                <div class="text-gray-900 font-mono text-sm">{{ substr($resident->no_kk_id, 0, -6) . '******' }}</div>
                            </div>
                            <div class="p-4 hover:bg-gray-50 transition-colors duration-150 flex">
                                <span class="font-medium text-gray-600 text-sm w-40">Nomor NIK:</span>
                                <div class="text-gray-900 font-mono text-sm">{{ substr($resident->nik, 0, -6) . '******' }}</div>
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
                                <div class="text-gray-900 text-sm">{{ $resident->pendidikan->nama ?? 'ID: ' . $resident->pendidikan_terakhir_id }}</div>
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
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-3 py-3 text-xs text-gray-900 font-medium">Kepala Keluarga</td>
                                        <td class="px-3 py-3 text-xs text-gray-900 font-medium">{{ $resident->nama }}</td>
                                        <td class="px-3 py-3 text-xs font-mono text-gray-600">{{ substr($resident->nik, 0, -6) . '******' }}</td>
                                    </tr>
                                    @if(isset($resident->keluarga_dalam_kk) && !empty($resident->keluarga_dalam_kk))
                                        @foreach($resident->keluarga_dalam_kk as $keluarga)
                                            @if($keluarga->nik !== $resident->nik)
                                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                                <td class="px-3 py-3 text-xs text-gray-900">{{ $keluarga->hubungan }}</td>
                                                <td class="px-3 py-3 text-xs text-gray-900">{{ $keluarga->nama_anggota }}</td>
                                                <td class="px-3 py-3 text-xs font-mono text-gray-600">{{ substr($keluarga->nik, 0, -6) . '******' }}</td>
                                            </tr>
                                            @endif
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
                            @if($resident->kewarganegaraan === 'WNA' && isset($resident->no_kitap) && !empty($resident->no_kitap))
                            <div class="p-4 hover:bg-gray-50 transition-colors duration-150 flex">
                                <span class="font-medium text-gray-600 text-sm w-40">No. KITAP:</span>
                                <div class="text-gray-900 font-mono text-sm">{{ $resident->no_kitap }}</div>
                            </div>
                            @endif
                            <div class="p-4 hover:bg-gray-50 transition-colors duration-150 flex">
                                <span class="font-medium text-gray-600 text-sm w-40">RT:</span>
                                <div class="text-gray-900 text-sm">02</div>
                            </div>
                            <div class="p-4 hover:bg-gray-50 transition-colors duration-150 flex">
                                <span class="font-medium text-gray-600 text-sm w-40">RW:</span>
                                <div class="text-gray-900 text-sm">01</div>
                            </div>
                            <div class="p-4 hover:bg-gray-50 transition-colors duration-150 flex">
                                <span class="font-medium text-gray-600 text-sm w-40">Alamat Lengkap:</span>
                                <div class="text-gray-900 text-sm">Jl. Mawar Indah No. 10, RT 02 / RW 01, Kel. Mekar Jaya, Kec. Sukamaju, Kab. Bogor</div>
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
                            @if($resident->penyandang_disabilitas && isset($resident->detail_disabilitas) && !empty($resident->detail_disabilitas))
                            <div class="p-4 hover:bg-gray-50 transition-colors duration-150 flex">
                                <span class="font-medium text-gray-600 text-sm w-40">Detail Disabilitas:</span>
                                <div class="text-gray-900 text-sm">{{ $resident->detail_disabilitas }}</div>
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
