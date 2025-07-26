<div>
    <style>
    @keyframes countUp {
        from { 
            opacity: 0; 
            transform: translateY(10px); 
        }
        to { 
            opacity: 1; 
            transform: translateY(0); 
        }
    }
    </style>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <x-card class="backdrop-blur-sm border border-white/30 transition-all duration-300 ease-in-out hover:-translate-y-1 hover:scale-[1.02] hover:shadow-[0_10px_25px_rgba(55,108,180,0.15)] bg-[#CCFAFF] border-[#62C7E2] text-[#2D9BB9] flex flex-col justify-center p-8 rounded-xl shadow-lg">
            <div class="flex items-center mb-2">
                <div class="p-3 bg-[#2D9BB9] bg-opacity-20 rounded-xl mr-4">
                    <x-heroicon-o-user-group class="h-12 w-12 text-[#2D9BB9]" />
                </div>
                <div class="flex-1">
                    <h2 class="text-lg font-semibold text-[#376CB4] mb-1">Total Penduduk</h2>
                    <h3 class="text-sm text-[#699CCF] mb-2">Terdaftar</h3>
                    <p class="text-4xl font-extrabold opacity-0 animate-[countUp_1.5s_ease-out_forwards] text-[#2D9BB9]">{{ number_format($totalPendudukTerdaftar) }}</p>
                </div>
            </div>
        </x-card>

        <x-card class="backdrop-blur-sm border border-white/30 transition-all duration-300 ease-in-out hover:-translate-y-1 hover:scale-[1.02] hover:shadow-[0_10px_25px_rgba(55,108,180,0.15)] bg-[#FFE4F2] border-[#EF81BA] text-[#EE53A3] flex flex-col justify-center p-8 rounded-xl shadow-lg">
            <div class="flex items-center mb-2">
                <div class="p-3 bg-[#EE53A3] bg-opacity-20 rounded-xl mr-4">
                    <x-heroicon-o-home-modern class="h-12 w-12 text-[#EE53A3]" />
                </div>
                <div class="flex-1">
                    <h2 class="text-lg font-semibold text-[#4E347E] mb-1">Total Keluarga</h2>
                    <h3 class="text-sm text-[#EF81BA] mb-2">Terdaftar</h3>
                    <p class="text-4xl font-extrabold opacity-0 animate-[countUp_1.5s_ease-out_forwards] text-[#EE53A3]">{{ number_format($totalKeluargaTerdaftar) }}</p>
                </div>
            </div>
        </x-card>
    </div>

    <!-- Visualisasi Data Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Pie Chart Gender -->
        <x-card class="backdrop-blur-sm border border-white/30 transition-all duration-300 ease-in-out hover:-translate-y-0.5 hover:shadow-[0_10px_25px_rgba(55,108,180,0.15)] bg-[#FFFFFF] rounded-xl shadow-lg p-6 border-[#ADC4DB]">
            <h3 class="text-lg font-semibold text-[#4E347E] mb-4 flex items-center">
                📊 Distribusi Gender
            </h3>
            <div class="relative h-64">
                <canvas id="genderChart"></canvas>
            </div>
            <div class="flex justify-center mt-4 space-x-6">
                <div class="flex items-center bg-[#FFF9FD] px-3 py-2 rounded-lg">
                    <div class="w-4 h-4 bg-[#376CB4] rounded-full mr-2"></div>
                    <span class="text-sm text-[#717171] font-medium">Laki-laki: {{ number_format($dataVisualisasi['gender']['Laki-laki']) }}</span>
                </div>
                <div class="flex items-center bg-[#FFF9FD] px-3 py-2 rounded-lg">
                    <div class="w-4 h-4 bg-[#EE53A3] rounded-full mr-2"></div>
                    <span class="text-sm text-[#717171] font-medium">Perempuan: {{ number_format($dataVisualisasi['gender']['Perempuan']) }}</span>
                </div>
            </div>
        </x-card>

        <!-- Doughnut Chart Usia -->
        <x-card class="backdrop-blur-sm border border-white/30 transition-all duration-300 ease-in-out hover:-translate-y-0.5 hover:shadow-[0_10px_25px_rgba(55,108,180,0.15)] bg-[#FFFFFF] rounded-xl shadow-lg p-6 border-[#ADC4DB]">
            <h3 class="text-lg font-semibold text-[#4E347E] mb-4 flex items-center">
                👨‍👩‍👧‍👦 Pengelompokkan Usia
            </h3>
            <div class="relative h-64">
                <canvas id="usiaChart"></canvas>
            </div>
            <div class="grid grid-cols-2 gap-2 mt-4">
                @foreach($dataVisualisasi['usia'] as $kelompok => $jumlah)
                <div class="flex items-center bg-[#FFF9FD] px-2 py-1 rounded">
                    <div class="w-3 h-3 rounded-full mr-2" style="background-color: {{ ['#376CB4', '#2D9BB9', '#699CCF', '#4E347E'][array_search($kelompok, array_keys($dataVisualisasi['usia']))] }}"></div>
                    <span class="text-xs text-[#717171] font-medium">{{ $kelompok }}: {{ number_format($jumlah) }}</span>
                </div>
                @endforeach
            </div>
        </x-card>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Bar Chart Horizontal Pekerjaan -->
        <x-card class="backdrop-blur-sm border border-white/30 transition-all duration-300 ease-in-out hover:-translate-y-0.5 hover:shadow-[0_10px_25px_rgba(55,108,180,0.15)] bg-[#FFFFFF] rounded-xl shadow-lg p-6 border-[#ADC4DB]">
            <h3 class="text-lg font-semibold text-[#4E347E] mb-4 flex items-center">
                💼 Distribusi Pekerjaan
            </h3>
            <div class="relative h-80">
                <canvas id="pekerjaanChart"></canvas>
            </div>
        </x-card>

        <!-- Progress Bar Style RT/RW -->
        <x-card class="backdrop-blur-sm border border-white/30 transition-all duration-300 ease-in-out hover:-translate-y-0.5 hover:shadow-[0_10px_25px_rgba(55,108,180,0.15)] bg-[#FFFFFF] rounded-xl shadow-lg p-6 border-[#ADC4DB]">
            <h3 class="text-lg font-semibold text-[#4E347E] mb-4 flex items-center">
                🏠 Warga per RT/RW
            </h3>
            <div class="space-y-3 max-h-80 overflow-y-auto scrollbar-thin scrollbar-thumb-[#699CCF] scrollbar-track-[#ADC4DB] hover:scrollbar-thumb-[#376CB4]">
                @php
                    $maxRTRW = max($dataVisualisasi['rtrw']);
                    $colors = ['bg-[#376CB4]', 'bg-[#2D9BB9]', 'bg-[#699CCF]', 'bg-[#4E347E]', 'bg-[#62C7E2]', 'bg-[#EE53A3]', 'bg-[#C5B6E1]', 'bg-[#457BC5]'];
                @endphp
                @foreach($dataVisualisasi['rtrw'] as $index => $rtrw)
                    @php $jumlah = $rtrw; $rt_rw = $index; @endphp
                    <div class="bg-[#FFF9FD] rounded-lg p-4 border border-[#ADC4DB] hover:shadow-md transition-all duration-300">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-semibold text-[#232323]">{{ $rt_rw }}</span>
                            <span class="text-sm font-bold text-[#376CB4]">{{ number_format($jumlah) }}</span>
                        </div>
                        <div class="w-full bg-[#ADC4DB] rounded-full h-3">
                            <div class="{{ $colors[$loop->index % count($colors)] }} h-3 rounded-full transition-[width] duration-[800ms] ease-out" 
                                 style="width: {{ ($jumlah / $maxRTRW) * 100 }}%"></div>
                        </div>
                        <div class="text-xs text-[#717171] mt-2">{{ number_format(($jumlah / $maxRTRW) * 100, 1) }}% dari RT/RW terbesar</div>
                    </div>
                @endforeach
            </div>
        </x-card>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <x-card class="backdrop-blur-sm border border-white/30 transition-all duration-300 ease-in-out hover:-translate-y-1 hover:scale-[1.02] hover:shadow-[0_10px_25px_rgba(55,108,180,0.15)] bg-gradient-to-br from-[#376CB4] to-[#457BC5] text-white p-4 rounded-xl shadow-lg border-[#699CCF]">
            <div class="flex items-center">
                <div class="p-2 bg-white bg-opacity-20 rounded-lg backdrop-blur-sm">
                    <x-heroicon-o-user-group class="h-6 w-6" />
                </div>
                <div class="ml-3">
                    <p class="text-sm opacity-90 font-medium">Dewasa (18+)</p>
                    <p class="text-lg font-bold opacity-0 animate-[countUp_1.5s_ease-out_forwards]">{{ number_format($dataVisualisasi['usia']['18-35'] + $dataVisualisasi['usia']['36-55'] + $dataVisualisasi['usia']['56+']) }}</p>
                </div>
            </div>
        </x-card>

        <x-card class="backdrop-blur-sm border border-white/30 transition-all duration-300 ease-in-out hover:-translate-y-1 hover:scale-[1.02] hover:shadow-[0_10px_25px_rgba(55,108,180,0.15)] bg-gradient-to-br from-[#2D9BB9] to-[#62C7E2] text-white p-4 rounded-xl shadow-lg border-[#699CCF]">
            <div class="flex items-center">
                <div class="p-2 bg-white bg-opacity-20 rounded-lg backdrop-blur-sm">
                    <x-heroicon-o-academic-cap class="h-6 w-6" />
                </div>
                <div class="ml-3">
                    <p class="text-sm opacity-90 font-medium">Anak (0-17)</p>
                    <p class="text-lg font-bold opacity-0 animate-[countUp_1.5s_ease-out_forwards]">{{ number_format($dataVisualisasi['usia']['0-17']) }}</p>
                </div>
            </div>
        </x-card>

        <x-card class="backdrop-blur-sm border border-white/30 transition-all duration-300 ease-in-out hover:-translate-y-1 hover:scale-[1.02] hover:shadow-[0_10px_25px_rgba(55,108,180,0.15)] bg-gradient-to-br from-[#4E347E] to-[#C5B6E1] text-white p-4 rounded-xl shadow-lg border-[#699CCF]">
            <div class="flex items-center">
                <div class="p-2 bg-white bg-opacity-20 rounded-lg backdrop-blur-sm">
                    <x-heroicon-o-briefcase class="h-6 w-6" />
                </div>
                <div class="ml-3">
                    <p class="text-sm opacity-90 font-medium">Bekerja</p>
                    <p class="text-lg font-bold opacity-0 animate-[countUp_1.5s_ease-out_forwards]">{{ number_format($dataVisualisasi['pekerjaan']['PNS'] + $dataVisualisasi['pekerjaan']['Swasta'] + $dataVisualisasi['pekerjaan']['Wiraswasta'] + $dataVisualisasi['pekerjaan']['Petani']) }}</p>
                </div>
            </div>
        </x-card>

        <x-card class="backdrop-blur-sm border border-white/30 transition-all duration-300 ease-in-out hover:-translate-y-1 hover:scale-[1.02] hover:shadow-[0_10px_25px_rgba(55,108,180,0.15)] bg-gradient-to-br from-[#EE53A3] to-[#EF81BA] text-white p-4 rounded-xl shadow-lg border-[#699CCF]">
            <div class="flex items-center">
                <div class="p-2 bg-white bg-opacity-20 rounded-lg backdrop-blur-sm">
                    <x-heroicon-o-home class="h-6 w-6" />
                </div>
                <div class="ml-3">
                    <p class="text-sm opacity-90 font-medium">Rata-rata/RT</p>
                    <p class="text-lg font-bold opacity-0 animate-[countUp_1.5s_ease-out_forwards]">{{ number_format(array_sum($dataVisualisasi['rtrw']) / count($dataVisualisasi['rtrw'])) }}</p>
                </div>
            </div>
        </x-card>
    </div>

    <x-card class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
            Aktivitas Terbaru
        </h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">No</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Tipe</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">NIK / No. KK</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Aksi</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Oleh Akun</th>
                        <th class="px-4 py-3 text-left text-sm font-medium text-gray-700">Waktu</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium">1</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                <x-heroicon-o-document-text class="h-4 w-4 mr-2 text-gray-400" />
                                <span class="text-sm font-medium text-gray-900">Data Warga</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-mono text-gray-600">32012345******</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-green-50 text-green-700 border border-green-200">
                                Tambah
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium">admin</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">2 jam yang lalu</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium">2</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                <x-heroicon-o-user-plus class="h-4 w-4 mr-2 text-gray-400" />
                                <span class="text-sm font-medium text-gray-900">Data Warga</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-mono text-gray-600">32012345******</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-blue-50 text-blue-700 border border-blue-200">
                                Edit
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium">petugas1</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">3 jam yang lalu</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium">3</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                <x-heroicon-o-document-text class="h-4 w-4 mr-2 text-gray-400" />
                                <span class="text-sm font-medium text-gray-900">Surat Kependudukan</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-mono text-gray-600">32012345******</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-green-50 text-green-700 border border-green-200">
                                Tambah
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium">admin</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">4 jam yang lalu</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium">4</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                <x-heroicon-o-user-plus class="h-4 w-4 mr-2 text-gray-400" />
                                <span class="text-sm font-medium text-gray-900">Data Warga</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-mono text-gray-600">32012345******</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-red-50 text-red-700 border border-red-200">
                                Hapus
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium">petugas2</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">6 jam yang lalu</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium">5</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                <x-heroicon-o-document-text class="h-4 w-4 mr-2 text-gray-400" />
                                <span class="text-sm font-medium text-gray-900">Surat Kependudukan</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-mono text-gray-600">32012345******</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-blue-50 text-blue-700 border border-blue-200">
                                Edit
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium">petugas1</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">1 hari yang lalu</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium">6</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                <x-heroicon-o-user-plus class="h-4 w-4 mr-2 text-gray-400" />
                                <span class="text-sm font-medium text-gray-900">Data Warga</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-mono text-gray-600">32012345******</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-green-50 text-green-700 border border-green-200">
                                Tambah
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium">admin</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">1 hari yang lalu</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </x-card>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Enhanced Chart Options with Custom Colors
        const defaultOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            animation: {
                duration: 1500,
                easing: 'easeInOutQuart'
            }
        };

        // Pie Chart untuk Gender dengan warna custom
        const genderCtx = document.getElementById('genderChart').getContext('2d');
        new Chart(genderCtx, {
            type: 'pie',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    data: [{{ $dataVisualisasi['gender']['Laki-laki'] }}, {{ $dataVisualisasi['gender']['Perempuan'] }}],
                    backgroundColor: ['#376CB4', '#EE53A3'],
                    borderWidth: 3,
                    borderColor: '#FFFFFF',
                    hoverOffset: 10,
                    hoverBorderWidth: 5
                }]
            },
            options: {
                ...defaultOptions,
                plugins: {
                    ...defaultOptions.plugins,
                    tooltip: {
                        backgroundColor: 'rgba(35, 35, 35, 0.9)',
                        titleColor: '#FFFFFF',
                        bodyColor: '#FFFFFF',
                        borderColor: '#376CB4',
                        borderWidth: 2,
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                return context.label + ': ' + context.parsed.toLocaleString() + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });

        // Doughnut Chart untuk Usia dengan warna custom
        const usiaCtx = document.getElementById('usiaChart').getContext('2d');
        new Chart(usiaCtx, {
            type: 'doughnut',
            data: {
                labels: ['0-17 tahun', '18-35 tahun', '36-55 tahun', '56+ tahun'],
                datasets: [{
                    data: [
                        {{ $dataVisualisasi['usia']['0-17'] }},
                        {{ $dataVisualisasi['usia']['18-35'] }},
                        {{ $dataVisualisasi['usia']['36-55'] }},
                        {{ $dataVisualisasi['usia']['56+'] }}
                    ],
                    backgroundColor: ['#376CB4', '#2D9BB9', '#699CCF', '#4E347E'],
                    borderWidth: 4,
                    borderColor: '#FFFFFF',
                    hoverOffset: 15,
                    hoverBorderWidth: 6
                }]
            },
            options: {
                ...defaultOptions,
                cutout: '60%',
                plugins: {
                    ...defaultOptions.plugins,
                    tooltip: {
                        backgroundColor: 'rgba(35, 35, 35, 0.9)',
                        titleColor: '#FFFFFF',
                        bodyColor: '#FFFFFF',
                        borderColor: '#376CB4',
                        borderWidth: 2,
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                return context.label + ': ' + context.parsed.toLocaleString() + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });

        // Horizontal Bar Chart untuk Pekerjaan dengan warna custom
        const pekerjaanCtx = document.getElementById('pekerjaanChart').getContext('2d');
        new Chart(pekerjaanCtx, {
            type: 'bar',
            data: {
                labels: [
                    'PNS', 'Swasta', 'Wiraswasta', 
                    'Petani', 'Ibu Rumah Tangga', 'Pelajar/Mahasiswa'
                ],
                datasets: [{
                    data: [
                        {{ $dataVisualisasi['pekerjaan']['PNS'] }},
                        {{ $dataVisualisasi['pekerjaan']['Swasta'] }},
                        {{ $dataVisualisasi['pekerjaan']['Wiraswasta'] }},
                        {{ $dataVisualisasi['pekerjaan']['Petani'] }},
                        {{ $dataVisualisasi['pekerjaan']['Ibu Rumah Tangga'] }},
                        {{ $dataVisualisasi['pekerjaan']['Pelajar/Mahasiswa'] }}
                    ],
                    backgroundColor: [
                        '#376CB4', '#2D9BB9', '#699CCF', 
                        '#4E347E', '#EE53A3', '#62C7E2'
                    ],
                    borderRadius: 8,
                    borderSkipped: false,
                    hoverBackgroundColor: [
                        '#457BC5', '#4D9EB4', '#ADC4DB',
                        '#C5B6E1', '#EF81BA', '#457BC5'
                    ]
                }]
            },
            options: {
                indexAxis: 'y',
                ...defaultOptions,
                plugins: {
                    ...defaultOptions.plugins,
                    tooltip: {
                        backgroundColor: 'rgba(35, 35, 35, 0.9)',
                        titleColor: '#FFFFFF',
                        bodyColor: '#FFFFFF',
                        borderColor: '#376CB4',
                        borderWidth: 2,
                        callbacks: {
                            label: function(context) {
                                return context.parsed.x.toLocaleString() + ' orang';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: {
                            color: '#ADC4DB',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#717171',
                            font: { size: 12 }
                        }
                    },
                    y: {
                        grid: { display: false },
                        ticks: {
                            color: '#717171',
                            font: { size: 12 }
                        }
                    }
                }
            }
        });

        setTimeout(() => {
            // Chart initialization selesai
        }, 500);
    });
    </script>
</div>
