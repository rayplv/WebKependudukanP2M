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

    public function render() {
        // For backend:
        // $latestActivities = ActivityLog::latest()->take(5)->get(); // Example: Fetch latest activities

        $latestActivities = [ // Dummy data
            ['type' => 'Surat Kependudukan', 'nik' => '3201010001234567', 'action' => 'diperbarui oleh Admin.', 'time' => '10 jam lalu.'],
            ['type' => 'Data Warga', 'nik' => '3201010001234567', 'action' => 'ditambahkan oleh Petugas A', 'time' => 'kemarin.'],
        ];

        return view('livewire.dashboard', compact('latestActivities'));
    }
}
