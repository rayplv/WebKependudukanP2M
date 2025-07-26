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

    // Modal properties
    public $showTambahModal = false;
    public $formData = [
        'nik' => '',
        'no_kk_id' => '',
        'nama' => '',
        'tempat_lahir' => '',
        'tanggal_lahir' => '',
        'jenis_kelamin' => '',
        'golongan_darah' => '',
        'agama_id' => '',
        'status_perkawinan' => '',
        'tanggal_perkawinan' => '',
        'tanggal_perceraian' => '',
        'pendidikan_terakhir_id' => '',
        'pekerjaan_id' => '',
        'kewarganegaraan' => 'WNI',
        'hubungan_keluarga_id' => '',
        'nama_ayah' => '',
        'nama_ibu' => '',
        'penyandang_disabilitas' => false
    ];

    protected $queryString = ['search', 'filterRW', 'filterRT', 'filterPendidikan', 'filterStatusPernikahan', 'filterTag'];

    public function resetFilter() {
        $this->reset(['search', 'filterRW', 'filterRT', 'filterPendidikan', 'filterStatusPernikahan', 'filterTag']);
        $this->resetPage();
    }

    public function openTambahModal() {
        $this->showTambahModal = true;
        $this->resetFormData();
    }

    public function closeTambahModal() {
        $this->showTambahModal = false;
        $this->resetFormData();
    }

    public function resetFormData() {
        $this->formData = [
            'nik' => '',
            'no_kk_id' => '',
            'nama' => '',
            'tempat_lahir' => '',
            'tanggal_lahir' => '',
            'jenis_kelamin' => '',
            'golongan_darah' => '',
            'agama_id' => '',
            'status_perkawinan' => '',
            'tanggal_perkawinan' => '',
            'tanggal_perceraian' => '',
            'pendidikan_terakhir_id' => '',
            'pekerjaan_id' => '',
            'kewarganegaraan' => 'WNI',
            'hubungan_keluarga_id' => '',
            'nama_ayah' => '',
            'nama_ibu' => '',
            'penyandang_disabilitas' => false
        ];
    }

    public function simpanDataWarga() {
        // Validasi data
        $validationRules = [
            'formData.nik' => 'required|string|min:16|max:16',
            'formData.no_kk_id' => 'required|string|min:16|max:16',
            'formData.nama' => 'required|string|max:255',
            'formData.tempat_lahir' => 'required|string|max:255',
            'formData.tanggal_lahir' => 'required|date',
            'formData.jenis_kelamin' => 'required|in:LAKI-LAKI,PEREMPUAN',
            'formData.golongan_darah' => 'required|in:A,B,AB,O',
            'formData.agama_id' => 'required|integer',
            'formData.status_perkawinan' => 'required|string',
            'formData.pendidikan_terakhir_id' => 'required|integer',
            'formData.hubungan_keluarga_id' => 'required|integer',
            'formData.nama_ayah' => 'required|string|max:255',
            'formData.nama_ibu' => 'required|string|max:255',
            'formData.kewarganegaraan' => 'required|in:WNI,WNA',
            'formData.penyandang_disabilitas' => 'boolean'
        ];

        // Tambahkan validasi kondisional
        if (in_array($this->formData['status_perkawinan'], ['Kawin', 'Cerai Hidup', 'Cerai Mati'])) {
            $validationRules['formData.tanggal_perkawinan'] = 'required|date';
        }

        if (in_array($this->formData['status_perkawinan'], ['Cerai Hidup', 'Cerai Mati'])) {
            $validationRules['formData.tanggal_perceraian'] = 'nullable|date';
        }

        if ($this->formData['pekerjaan_id']) {
            $validationRules['formData.pekerjaan_id'] = 'integer';
        }

        $this->validate($validationRules, [
            'formData.nik.required' => 'NIK wajib diisi',
            'formData.nik.min' => 'NIK harus 16 digit',
            'formData.nik.max' => 'NIK harus 16 digit',
            'formData.no_kk_id.required' => 'No. KK wajib diisi',
            'formData.no_kk_id.min' => 'No. KK harus 16 digit',
            'formData.no_kk_id.max' => 'No. KK harus 16 digit',
            'formData.nama.required' => 'Nama wajib diisi',
            'formData.tempat_lahir.required' => 'Tempat lahir wajib diisi',
            'formData.tanggal_lahir.required' => 'Tanggal lahir wajib diisi',
            'formData.jenis_kelamin.required' => 'Jenis kelamin wajib dipilih',
            'formData.golongan_darah.required' => 'Golongan darah wajib dipilih',
            'formData.agama_id.required' => 'Agama wajib dipilih',
            'formData.status_perkawinan.required' => 'Status perkawinan wajib dipilih',
            'formData.pendidikan_terakhir_id.required' => 'Pendidikan terakhir wajib dipilih',
            'formData.hubungan_keluarga_id.required' => 'Hubungan dalam KK wajib dipilih',
            'formData.nama_ayah.required' => 'Nama ayah wajib diisi',
            'formData.nama_ibu.required' => 'Nama ibu wajib diisi',
            'formData.kewarganegaraan.required' => 'Kewarganegaraan wajib dipilih',
            'formData.tanggal_perkawinan.required' => 'Tanggal perkawinan wajib diisi'
        ]);

        // Untuk backend: simpan ke database
        // Resident::create($this->formData);

        // Untuk frontend: tampilkan pesan sukses
        session()->flash('message', 'Data warga berhasil disimpan!');
        session()->flash('type', 'success');

        $this->closeTambahModal();
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
