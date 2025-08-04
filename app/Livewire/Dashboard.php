<?php
namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public $totalPendudukTerdaftar;
    public $totalKeluargaTerdaftar;

    public function mount()
    {
        $this->totalPendudukTerdaftar = DB::table('data_pribadi')->count();
        $this->totalKeluargaTerdaftar = DB::table('data_keluarga')->count();
    }

    public function hideNik($nik)
    {
        return substr($nik, 0, 10) . '******';
    }

    public function render()
    {
        // Hitung distribusi usia berdasarkan tanggal_lahir
        $usia = DB::table('data_pribadi')
            ->select(DB::raw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) as umur'))
            ->get()
            ->pluck('umur');

        $dataUsia = [
            '0-17'  => $usia->filter(fn($u) => $u <= 17)->count(),
            '18-35' => $usia->filter(fn($u) => $u >= 18 && $u <= 35)->count(),
            '36-55' => $usia->filter(fn($u) => $u >= 36 && $u <= 55)->count(),
            '56+'   => $usia->filter(fn($u) => $u >= 56)->count(),
        ];

        // Distribusi gender
        $dataGender = DB::table('data_pribadi')
            ->select(DB::raw("
                CASE 
                    WHEN jenis_kelamin = 'LAKI-LAKI' THEN 'Laki-laki'
                    WHEN jenis_kelamin = 'PEREMPUAN' THEN 'Perempuan'
                    ELSE jenis_kelamin
                END as label
            "), DB::raw('COUNT(*) as total'))
            ->groupBy('label')
            ->pluck('total', 'label')
            ->toArray();


        // Distribusi RT/RW
        $dataRtRw = DB::table('data_keluarga')
            ->select(DB::raw("CONCAT('RT ', LPAD(rt, 2, '0'), '/RW ', LPAD(rw, 2, '0')) as rtrw"), DB::raw('COUNT(*) as total'))
            ->groupBy('rtrw')
            ->pluck('total', 'rtrw')
            ->toArray();

        // Distribusi pekerjaan
        $dataPekerjaan = DB::table('data_pribadi')
            ->join('pekerjaan', 'data_pribadi.pekerjaan_id', '=', 'pekerjaan.id')
            ->select('pekerjaan.nama', DB::raw('COUNT(*) as total'))
            ->groupBy('pekerjaan.nama')
            ->orderByDesc('total')
            ->limit(6)
            ->pluck('total', 'pekerjaan.nama')
            ->toArray();



        // Dummy activity
        $latestActivities = [
            ['type' => 'Surat Kependudukan', 'nik' => '3201010001234567', 'action' => 'diperbarui oleh Admin.', 'time' => '10 jam lalu.'],
            ['type' => 'Data Warga', 'nik' => '3201010001234567', 'action' => 'ditambahkan oleh Petugas A', 'time' => 'kemarin.'],
        ];

        $dataVisualisasi = [
            'usia' => $dataUsia,
            'gender' => $dataGender,
            'rtrw' => $dataRtRw,
            'pekerjaan' => $dataPekerjaan
        ];

        return view('livewire.dashboard', compact('latestActivities', 'dataVisualisasi'));
    }
}
