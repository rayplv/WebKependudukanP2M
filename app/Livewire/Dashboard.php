<?php
namespace App\Livewire;

use Livewire\Component;

class Dashboard extends Component {
    public $totalPendudukTerdaftar = 12345; // Dummy data
    public $totalKeluargaTerdaftar = 8723;  // Dummy data

    // For backend:
    // public function mount()
    // {
    //     $this->totalPendudukTerdaftar = User::count(); // Example: Assuming 'users' table represents residents
    //     $this->totalKeluargaTerdaftar = Family::count(); // Example: Assuming 'families' table
    // }

    public function hideNik($nik) {
        return substr($nik, 0, 10) . '******';
    }

    public function render() {
        // For backend:
        // $latestActivities = ActivityLog::latest()->take(5)->get(); // Example: Fetch latest activities

        $latestActivities = [ // Dummy data
            ['type' => 'Surat Kependudukan', 'nik' => '3201010001234567', 'action' => 'diperbarui oleh Admin.', 'time' => '10 jam lalu.'],
            ['type' => 'Data Warga', 'nik' => '3201010001234567', 'action' => 'ditambahkan oleh Petugas A', 'time' => 'kemarin.'],
        ];

        // Dummy data untuk visualisasi
        $dataVisualisasi = [
            'usia' => [
                '0-17' => 2456,
                '18-35' => 4567,
                '36-55' => 3890,
                '56+' => 1432
            ],
            'gender' => [
                'Laki-laki' => 6234,
                'Perempuan' => 6111
            ],
            'rtrw' => [
                'RT 01/RW 01' => 445,
                'RT 02/RW 01' => 523,
                'RT 03/RW 01' => 467,
                'RT 01/RW 02' => 389,
                'RT 02/RW 02' => 412,
                'RT 03/RW 02' => 398,
                'RT 01/RW 03' => 356,
                'RT 02/RW 03' => 445
            ],
            'pekerjaan' => [
                'PNS' => 1234,
                'Swasta' => 3456,
                'Wiraswasta' => 2345,
                'Petani' => 1890,
                'Ibu Rumah Tangga' => 2567,
                'Pelajar/Mahasiswa' => 1453
            ]
        ];

        return view('livewire.dashboard', compact('latestActivities', 'dataVisualisasi'));
    }
}
