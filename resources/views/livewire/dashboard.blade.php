<div>
    <h1 class="text-2xl font-bold text-gray-800 mb-6">DATA WARGA DESA</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <x-card class="bg-[#CCEEFF] text-[#2c9bb9] flex flex-col justify-center p-8 rounded-xl">
            <div class="flex items-center mb-2">
                <x-heroicon-o-user-group class="h-16 w-16 opacity-75 text-[#2c9bb9]" />
                <div class="ml-4">
                    <h2 class="text-xl font-semibold">Total Penduduk Terdaftar</h2>
                    <p class="text-3xl font-extrabold">{{ number_format($totalPendudukTerdaftar) }}</p>
                </div>
            </div>
        </x-card>

        <x-card class="bg-[#ffe4f2] text-[#ee53a3] flex flex-col justify-center p-8 rounded-xl">
            <div class="flex items-center mb-2">
                <x-heroicon-o-home-modern class="h-16 w-16 opacity-75 text-[#ee53a3]" />
                <div class="ml-4">
                    <h2 class="text-xl font-semibold">Total Keluarga Terdaftar</h2>
                    <p class="text-3xl font-extrabold">{{ number_format($totalKeluargaTerdaftar) }}</p>
                </div>
            </div>
        </x-card>
    </div>

    <x-card class="rounded-xl shadow-lg p-6">
        <h2 class="text-xl font-semibold text-[#4B0082] mb-4">Aktivitas Terbaru</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">
                            No</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">
                            Tipe</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">
                            NIK / No. KK</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">
                            Aksi</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">
                            Oleh Akun</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b">
                            Waktu</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">1</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <x-heroicon-o-document-text class="h-5 w-5 mr-2 text-blue-500" />
                                <span class="text-sm font-medium text-gray-900">Data Warga</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900">3201234567890123</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Tambah
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">admin</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2 jam yang lalu</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">2</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <x-heroicon-o-user-plus class="h-5 w-5 mr-2 text-green-500" />
                                <span class="text-sm font-medium text-gray-900">Data Warga</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900">3201234567890124</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                Edit
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">petugas1</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">3 jam yang lalu</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">3</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <x-heroicon-o-document-text class="h-5 w-5 mr-2 text-blue-500" />
                                <span class="text-sm font-medium text-gray-900">Surat Kependudukan</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900">3201234567890125</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Tambah
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">admin</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">4 jam yang lalu</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">4</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <x-heroicon-o-user-plus class="h-5 w-5 mr-2 text-green-500" />
                                <span class="text-sm font-medium text-gray-900">Data Warga</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900">3201234567890126</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                Hapus
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">petugas2</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">6 jam yang lalu</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">5</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <x-heroicon-o-document-text class="h-5 w-5 mr-2 text-blue-500" />
                                <span class="text-sm font-medium text-gray-900">Surat Kependudukan</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900">3201234567890127</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                Edit
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">petugas1</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">1 hari yang lalu</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">6</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <x-heroicon-o-user-plus class="h-5 w-5 mr-2 text-green-500" />
                                <span class="text-sm font-medium text-gray-900">Data Warga</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900">3201234567890128</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Tambah
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">admin</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">1 hari yang lalu</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </x-card>
</div>
