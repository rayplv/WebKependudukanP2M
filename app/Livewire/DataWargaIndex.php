<?php
namespace App\Livewire;

use App\Models\DataPribadi;
use App\Models\DataKeluarga;
use App\Models\Agama;
use App\Models\PendidikanTerakhir;
use App\Models\Pekerjaan;
use App\Models\HubunganKeluarga;
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

    // ...existing code...

    public function simpanDataWarga() {
        // ...existing validation code...

        // Simpan ke database
        DataPribadi::create($this->formData);

        session()->flash('message', 'Data warga berhasil disimpan!');
        session()->flash('type', 'success');

        $this->closeTambahModal();
        $this->resetPage();
    }

    public function render() {
        // Query data dari database
        $query = DataPribadi::with(['dataKeluarga', 'agama', 'pendidikanTerakhir', 'pekerjaan', 'hubunganKeluarga']);
        
        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('nama', 'like', '%' . $this->search . '%')
                  ->orWhere('nik', 'like', '%' . $this->search . '%')
                  ->orWhere('no_kk_id', 'like', '%' . $this->search . '%');
            });
        }
        
        if (!empty($this->filterRW)) {
            $query->whereHas('dataKeluarga', function($q) {
                $q->where('rw', $this->filterRW);
            });
        }
        
        if (!empty($this->filterRT)) {
            $query->whereHas('dataKeluarga', function($q) {
                $q->where('rt', $this->filterRT);
            });
        }
        
        if (!empty($this->filterPendidikan)) {
            $query->where('pendidikan_terakhir_id', $this->filterPendidikan);
        }
        
        if (!empty($this->filterStatusPernikahan)) {
            $query->where('status_perkawinan', $this->filterStatusPernikahan);
        }
        
        if (!empty($this->filterTag)) {
            if ($this->filterTag === 'Penyandang Disabilitas') {
                $query->where('penyandang_disabilitas', true);
            }
        }
        
        $dataWarga = $query->paginate(10);

        // Ambil data untuk options dari database
        $rwOptions = DataKeluarga::distinct()->pluck('rw', 'rw')->filter()->toArray();
        $rtOptions = DataKeluarga::distinct()->pluck('rt', 'rt')->filter()->toArray();
        $pendidikanOptions = PendidikanTerakhir::pluck('nama', 'id')->toArray();
        $statusPernikahanOptions = [
            'Belum Kawin' => 'Belum Kawin',
            'Kawin' => 'Kawin', 
            'Cerai Hidup' => 'Cerai Hidup',
            'Cerai Mati' => 'Cerai Mati'
        ];
        $tagOptions = [
            'Penyandang Disabilitas' => 'Penyandang Disabilitas',
            'Lansia' => 'Lansia',
            'Balita' => 'Balita'
        ];

        // Data untuk form options
        $agamaOptions = Agama::pluck('nama', 'id')->toArray();
        $pekerjaanOptions = Pekerjaan::pluck('nama', 'id')->toArray();
        $hubunganKeluargaOptions = HubunganKeluarga::pluck('nama', 'id')->toArray();
        $dataKeluargaOptions = DataKeluarga::pluck('no_kk', 'no_kk')->toArray();

        return view('livewire.data-warga-index', compact(
            'dataWarga', 
            'rwOptions', 
            'rtOptions', 
            'pendidikanOptions', 
            'statusPernikahanOptions', 
            'tagOptions',
            'agamaOptions',
            'pekerjaanOptions', 
            'hubunganKeluargaOptions',
            'dataKeluargaOptions'
        ));
    }
}