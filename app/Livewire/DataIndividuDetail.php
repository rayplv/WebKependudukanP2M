<?php
namespace App\Livewire;

use Livewire\Component;

class DataIndividuDetail extends Component {
    public $residentId;
    public $resident;

    public function mount($id) {
        $this->residentId = $id;
        // For backend:
        // $this->resident = Resident::findOrFail($id);
        // For dummy data:
        $this->resident = (object) [
            'id'                     => 1,
            'nama_lengkap'           => 'Budi Santoso',
            'nik'                    => '32010101234567890',
            'status'                 => 'Hidup',
            'nomor_kk'               => '3201010001234567',
            'tempat_tanggal_lahir'   => 'Bogor, 15 Agustus 1989',
            'usia'                   => '35 Tahun',
            'pendidikan_terakhir'    => 'S1',
            'gol_darah'              => '-',
            'agama'                  => 'Islam',
            'status_pernikahan'      => 'Menikah',
            'rt'                     => '02',
            'rw'                     => '01',
            'alamat_lengkap'         => 'Jl. Mawar Indah No. 10, RT 02 / RW 01, Kel. Mekar Jaya, Kec. Sukamaju, Kab. Bogor',
            'penyandang_disabilitas' => 'Tidak',
            'keluarga_dalam_kk'      => [
                (object) ['hubungan' => 'Kepala Keluarga', 'nama_anggota' => 'Budi Santoso', 'nik' => '32010101234567890'],
                (object) ['hubungan' => 'Istri', 'nama_anggota' => 'Ani Fitriani', 'nik' => '32010101234567891'],
                (object) ['hubungan' => 'Anak', 'nama_anggota' => 'Joko Santoso', 'nik' => '32010101234567892'],
            ],
        ];
    }

    public function render() {
        return view('livewire.data-individu-detail');
    }

    public function editData() {
        // For backend: Redirect to edit page
        // return redirect()->route('data-warga.edit', $this->resident->id);
        // For frontend:
        session()->flash('message', 'Fitur edit data akan diimplementasikan oleh backend.');
    }

    public function hapusData() {
        // For backend: Delete logic, show confirmation
        // if (confirm('Are you sure you want to delete this data?')) {
        //     $this->resident->delete();
        //     session()->flash('message', 'Data berhasil dihapus.');
        //     return redirect()->route('data-warga.index');
        // }
        // For frontend:
        session()->flash('message', 'Fitur hapus data akan diimplementasikan oleh backend.');
    }
}
