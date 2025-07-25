<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class DataWargaIndex extends Component {
    use WithPagination;

    public $search                 = '';
    public $filterRW               = '';
    public $filterRT               = '';
    public $filterPendidikan       = '';
    public $filterStatusPernikahan = '';
    public $filterTag              = '';

    protected $queryString = ['search', 'filterRW', 'filterRT', 'filterPendidikan', 'filterStatusPernikahan', 'filterTag'];

    public function resetFilter() {
        $this->reset(['search', 'filterRW', 'filterRT', 'filterPendidikan', 'filterStatusPernikahan', 'filterTag']);
        $this->resetPage();
    }

    public function render() {
        // For backend:
        // $query = Resident::query();
        // if (!empty($this->search)) {
        //     $query->where('name', 'like', '%' . $this->search . '%')
        //           ->orWhere('nik', 'like', '%' . $this->search . '%')
        //           ->orWhere('no_kk', 'like', '%' . $this->search . '%');
        // }
        // if (!empty($this->filterRW)) {
        //     $query->where('rw', $this->filterRW);
        // }
        // if (!empty($this->filterRT)) {
        //     $query->where('rt', $this->filterRT);
        // }
        // if (!empty($this->filterPendidikan)) {
        //     $query->where('education', $this->filterPendidikan);
        // }
        // if (!empty($this->filterStatusPernikahan)) {
        //     $query->where('marital_status', $this->filterStatusPernikahan);
        // }
        // if (!empty($this->filterTag)) {
        //     $query->whereJsonContains('tags', $this->filterTag);
        // }
        // $dataWarga = $query->paginate(10);

        // Dummy data for frontend
        $dataWarga = new \Illuminate\Pagination\LengthAwarePaginator(
            [
                (object) [
                    'id'                   => 1,
                    'nama'                 => 'Budi Santoso',
                    'nik'                  => '3201010001234567',
                    'no_kk'                => '3201010001234567',
                    'tempat_tanggal_lahir' => 'Bogor, 15 Agustus 1989',
                    'jenis_kelamin'        => 'Laki-laki',
                ],
                (object) [
                    'id'                   => 2,
                    'nama'                 => 'Siti Aminah',
                    'nik'                  => '3201010001234568',
                    'no_kk'                => '3201010001234567',
                    'tempat_tanggal_lahir' => 'Jakarta, 10 Januari 1992',
                    'jenis_kelamin'        => 'Perempuan',
                ],
                (object) [
                    'id'                   => 3,
                    'nama'                 => 'Joko Santoso',
                    'nik'                  => '3201010001234569',
                    'no_kk'                => '3201010001234567',
                    'tempat_tanggal_lahir' => 'Bogor, 20 Maret 2015',
                    'jenis_kelamin'        => 'Laki-laki',
                ],
                (object) [
                    'id'                   => 4,
                    'nama'                 => 'Dewi Lestari',
                    'nik'                  => '3201010001234570',
                    'no_kk'                => '3201010001234570',
                    'tempat_tanggal_lahir' => 'Surabaya, 5 Mei 1980',
                    'jenis_kelamin'        => 'Perempuan',
                ],
                (object) [
                    'id'                   => 5,
                    'nama'                 => 'Agus Permana',
                    'nik'                  => '3201010001234571',
                    'no_kk'                => '3201010001234570',
                    'tempat_tanggal_lahir' => 'Bandung, 12 Desember 2000',
                    'jenis_kelamin'        => 'Laki-laki',
                ],
                (object) [
                    'id'                   => 6,
                    'nama'                 => 'Fitriani',
                    'nik'                  => '3201010001234572',
                    'no_kk'                => '3201010001234570',
                    'tempat_tanggal_lahir' => 'Medan, 8 Juni 2005',
                    'jenis_kelamin'        => 'Perempuan',
                ],
            ],
            1075, // Total items
            10,   // Per page
            1,    // Current page
            ['path' => route('data-warga.index')]
        );

        $rwOptions               = ['01' => '01', '02' => '02', '03' => '03'];                                                                                 // Dummy options
        $rtOptions               = ['01' => '01', '02' => '02', '03' => '03', '04' => '04'];                                                                   // Dummy options
        $pendidikanOptions       = ['SD' => 'SD', 'SMP' => 'SMP', 'SMA' => 'SMA', 'D3' => 'D3', 'S1' => 'S1'];                                                 // Dummy options
        $statusPernikahanOptions = ['Belum Menikah' => 'Belum Menikah', 'Menikah' => 'Menikah', 'Cerai Hidup' => 'Cerai Hidup', 'Cerai Mati' => 'Cerai Mati']; // Dummy options
        $tagOptions              = ['Penyandang Disabilitas' => 'Penyandang Disabilitas', 'Lansia' => 'Lansia', 'Balita' => 'Balita'];                         // Dummy options

        return view('livewire.data-warga-index', compact('dataWarga', 'rwOptions', 'rtOptions', 'pendidikanOptions', 'statusPernikahanOptions', 'tagOptions'));
    }
}
