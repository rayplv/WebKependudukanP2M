<?php
namespace App\Livewire;

use Livewire\Component;

class DataIndividuDetail extends Component {
    public $residentId;
    public $resident;

    public function mount($id) {
        $this->residentId = $id;
        // For backend:
        // $this->resident = DataPribadi::findOrFail($id);
        // For dummy data using actual database structure:
        $this->resident = (object) [
            'nik'                     => '3201010101010001',
            'no_kk_id'                => '3210010101010001',
            'hubungan_keluarga_id'    => 1,
            'nama'                    => 'BUDI SANTOSA',
            'tempat_lahir'            => 'Bandung',
            'tanggal_lahir'           => '1975-02-15',
            'jenis_kelamin'           => 'LAKI-LAKI',
            'golongan_darah'          => 'O',
            'agama_id'                => 1,
            'status_perkawinan'       => 'Kawin',
            'tanggal_perkawinan'      => '1995-06-20',
            'tanggal_perceraian'      => null,
            'pendidikan_terakhir_id'  => 2,
            'pekerjaan_id'            => 5,
            'kewarganegaraan'         => 'WNA',
            'penyandang_disabilitas'  => true,
            'detail_disabilitas'      => 'Tunanetra parsial (penglihatan terbatas)',
            'nama_ayah'               => 'SUDARSO',
            'nama_ibu'                => 'SRI WAHYUNI',
            'no_paspor'               => 'A1234567',
            'no_kitap'                => 'KITAP123456789',
            // Relationship objects
            'agama'                   => (object) ['nama' => 'Islam'],
            'pendidikan'              => (object) ['nama' => 'TAMAT SD / SEDERAJAT'],
            'pekerjaan'               => (object) ['nama' => 'Pegawai Negeri Sipil'],
            'hubungan_keluarga'       => (object) ['nama' => 'KEPALA KELUARGA'],
            'keluarga_dalam_kk'       => [
                (object) ['hubungan' => 'KEPALA KELUARGA', 'nama_anggota' => 'BUDI SANTOSA', 'nik' => '3201010101010001'],
                (object) ['hubungan' => 'ISTRI', 'nama_anggota' => 'SRI LESTARI', 'nik' => '3201010101010002'],
                (object) ['hubungan' => 'ANAK', 'nama_anggota' => 'ANDI SANTOSA', 'nik' => '3201010101010003'],
                (object) ['hubungan' => 'ANAK', 'nama_anggota' => 'NINA SANTOSA', 'nik' => '3201010101010004'],
                (object) ['hubungan' => 'PEMBANTU', 'nama_anggota' => 'SUPARTO', 'nik' => '3201010101010005'],
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
