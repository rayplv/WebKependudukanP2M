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
use Illuminate\Support\Facades\Auth;

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
        'penyandang_disabilitas_check' => '',
        'penyandang_disabilitas' => '',
        'no_paspor' => '',
        'no_kitap' => ''
    ];
 
    protected $rules = [    // untuk validasi   
    'formData.nik' => 'required|digits:16|unique:data_pribadi,nik',
    'formData.no_kk_id' => 'required|digits:16',
    'formData.nama' => 'required|string|min:3',
    'formData.tempat_lahir' => 'required|string|min:2',
    'formData.tanggal_lahir' => 'required|date',
    'formData.jenis_kelamin' => 'required|in:LAKI-LAKI,PEREMPUAN',
    'formData.agama_id' => 'required|exists:agama,id',
    'formData.status_perkawinan' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
    'formData.pendidikan_terakhir_id' => 'required|exists:pendidikan_terakhir,id',
    'formData.pekerjaan_id' => 'required|exists:pekerjaan,id',
    'formData.hubungan_keluarga_id' => 'required|exists:hubungan_keluarga,id',
    'formData.kewarganegaraan' => 'required|in:WNI,WNA',
    'formData.golongan_darah' => 'required|in:A,B,AB,O',
    'formData.no_paspor' => 'nullable|string|size:8',
    'formData.no_kitap' => 'nullable|string|size:11',
    'formData.nama_ayah' => 'required|string|min:3',
    'formData.nama_ibu' => 'required|string|min:3',
];

    public $kkExists = null;
    public $checkingKK = false;
    public $kkData = [
        'alamat' => '',
        'rt' => '',
        'rw' => '',
        'tanggal_dikeluarkan' => ''
    ];

    protected $queryString = ['search', 'filterRW', 'filterRT', 'filterPendidikan', 'filterStatusPernikahan', 'filterTag'];

    // ...existing code...

    public function checkKKExists()
    {
        $noKK = $this->formData['no_kk_id'] ?? '';
        
        if (strlen($noKK) !== 16) {
            session()->flash('message', 'No. KK harus 16 digit.');
            session()->flash('type', 'error');
            return;
        }
        
        $this->checkingKK = true;
        
        $kk = DataKeluarga::find($noKK);
        
        if ($kk) {
            $this->kkExists = true;
            // Reset KK data karena KK sudah ada
            $this->resetKKData();
            session()->flash('message', 'No. KK ditemukan dalam database.');
            session()->flash('type', 'success');
        } else {
            $this->kkExists = false;
            // KK belum ada, siapkan form untuk data KK baru
            session()->flash('message', 'No. KK belum terdaftar. Silakan isi data KK di bawah.');
            session()->flash('type', 'info');
        }
        
        $this->checkingKK = false;
    }

    public function resetKKData()
    {
        $this->kkData = [
            'alamat' => '',
            'rt' => '',
            'rw' => '',
            'tanggal_dikeluarkan' => ''
        ];
    }

     public function openTambahModal() {
        $this->reset('formData');
        $this->resetKKData();
        $this->kkExists = null;
        $this->checkingKK = false;
        
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
            'penyandang_disabilitas_check' => '',
            'penyandang_disabilitas' => '',
            'detail_disabilitas' => '',
            'no_paspor' => '',
            'no_kitap' => ''
        ];
        $this->showTambahModal = true;
    }


    public function closeTambahModal() {
        $this->showTambahModal = false;
        $this->reset('formData');
        $this->resetKKData();
        $this->resetValidation();
        $this->kkExists = null;
        $this->checkingKK = false;
    }

    public function simpanDataWarga() {
        $this->validate();
        try {
            if($this->formData['status_perkawinan'] === 'Kawin'){
                $this->validate([
                    'formData.tanggal_perkawinan' => 'required|date',
                ]);
            }else if($this->formData['status_perkawinan'] === 'Cerai Hidup' || $this->formData['status_perkawinan'] === 'Cerai Mati'){
                $this->validate([
                    'formData.tanggal_perkawinan' => 'required|date',
                    'formData.tanggal_perceraian' => 'required|date',
                ]);
            }

            if($this->formData['penyandang_disabilitas_check'] === true){
                $this->validate([
                    'formData.penyandang_disabilitas' => 'required|string|min:3',
                ]);
            }

            // Validasi apakah KK sudah dicek
            if ($this->kkExists === null) {
                session()->flash('message', 'Silakan cek No. KK terlebih dahulu.');
                session()->flash('type', 'error');
                return;
            }

            // Validasi data KK baru jika KK belum ada
            if ($this->kkExists === false) {
                $this->validate([
                    'kkData.alamat' => 'required|string|min:5',
                    'kkData.rt' => 'required|string|min:1|max:3',
                    'kkData.rw' => 'required|string|min:1|max:3',
                    'kkData.tanggal_dikeluarkan' => 'required|date',
                ]);
            }

            // Ubah semua value kosong menjadi null pada formData
            foreach ($this->formData as $key => $value) {
                if ($value === '') {
                    $this->formData[$key] = null;
                }
            }

            // Handle status pernikahan
            if($this->formData['status_perkawinan'] === 'Belum Kawin'){
                $this->formData['tanggal_perkawinan'] = null;
                $this->formData['tanggal_perceraian'] = null;
            }else if($this->formData['status_perkawinan'] === 'Kawin'){
                $this->formData['tanggal_perceraian'] = null;
            }
            
            // Handle empty dates
            if($this->formData['tanggal_perkawinan'] === ''){
                $this->formData['tanggal_perkawinan'] = null;
            }
            if($this->formData['tanggal_perceraian'] === ''){
                $this->formData['tanggal_perceraian'] = null;
            }
            
            $noKK = $this->formData['no_kk_id'];
            
            // Cek dan buat KK jika belum ada
            $kk = DataKeluarga::find($noKK);
            if (!$kk && $this->kkExists === false) {
                // Validasi data KK jika KK baru
                if (empty($this->kkData['alamat'])) {
                    session()->flash('message', 'Alamat KK wajib diisi untuk KK baru.');
                    session()->flash('type', 'error');
                    return;
                }
                
                $kk = DataKeluarga::create([
                    'no_kk' => $noKK,
                    'alamat' => $this->kkData['alamat'],
                    'rt' => $this->kkData['rt'] ?: null,
                    'rw' => $this->kkData['rw'] ?: null,
                    'tanggal_dikeluarkan' => $this->kkData['tanggal_dikeluarkan'] ?: null,
                ]);
            }
            
            $this->formData['no_kk_id'] = $kk->no_kk;
            DataPribadi::create($this->formData);

            session()->flash('message', 'Data warga berhasil disimpan!');
            session()->flash('type', 'success');

            $this->closeTambahModal();
            $this->resetPage();

        } catch (\Exception $e) {
            session()->flash('message', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
            session()->flash('type', 'error');
        }
    }

    public function render() {
        // Query data dari database
        $query = DataPribadi::with(['dataKeluarga', 'agama', 'pendidikanTerakhir', 'pekerjaan', 'hubunganKeluarga']);
        
        // Jika user tidak login
        if (!Auth::check()) {
            // Jika tidak ada pencarian NIK, return kosong
            if (empty($this->search)) {
                $dataWarga = $query->whereRaw('1 = 0')->paginate(10); // Query yang selalu return kosong
                
                return view('livewire.data-warga-index', compact('dataWarga'));
            }
            
            // Hanya cari berdasarkan NIK dan harus exact match atau partial dari depan
            $query->where('nik',  $this->search);
        } else {
            // Jika user login (admin), tampilkan semua filtering seperti biasa
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
        }
        
        $dataWarga = $query->paginate(10);

        // Data untuk options (hanya untuk admin)
        if (Auth::check()) {
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
        } else {
            // Untuk user tidak login, hanya return data warga
            return view('livewire.data-warga-index', compact('dataWarga'));
        }
        
    }
}