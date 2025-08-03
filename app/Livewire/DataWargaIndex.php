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
        'penyandang_disabilitas' => false,
        'detail_disabilitas' => '',
        'no_paspor' => '',
        'no_kitap' => ''
    ];

    protected $queryString = ['search', 'filterRW', 'filterRT', 'filterPendidikan', 'filterStatusPernikahan', 'filterTag'];

    // ...existing code...

    public function openTambahModal() {
        $this->reset('formData');
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
        $this->showTambahModal = true;
    }

    public function closeTambahModal() {
        $this->showTambahModal = false;
        $this->reset('formData');
    }

    protected function rules() {
        return [
            'formData.nik' => 'required|string|size:16|unique:data_pribadi,nik',
            'formData.no_kk_id' => 'required|string|size:16',
            'formData.nama' => 'required|string|min:2|max:100',
            'formData.tempat_lahir' => 'required|string|min:2|max:50',
            'formData.tanggal_lahir' => 'required|date|before:today',
            'formData.jenis_kelamin' => 'required|in:LAKI-LAKI,PEREMPUAN',
            'formData.golongan_darah' => 'required|in:A,B,AB,O',
            'formData.agama_id' => 'required|exists:agama,id',
            'formData.status_perkawinan' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'formData.tanggal_perkawinan' => 'nullable|date|before_or_equal:today|required_if:formData.status_perkawinan,Kawin,Cerai Hidup,Cerai Mati',
            'formData.tanggal_perceraian' => 'nullable|date|before_or_equal:today|after:formData.tanggal_perkawinan|required_if:formData.status_perkawinan,Cerai Hidup,Cerai Mati',
            'formData.pendidikan_terakhir_id' => 'required|exists:pendidikan_terakhir,id',
            'formData.pekerjaan_id' => 'nullable|exists:pekerjaan,id',
            'formData.kewarganegaraan' => 'required|in:WNI,WNA',
            'formData.hubungan_keluarga_id' => 'required|exists:hubungan_keluarga,id',
            'formData.nama_ayah' => 'required|string|min:2|max:100',
            'formData.nama_ibu' => 'required|string|min:2|max:100',
            'formData.penyandang_disabilitas' => 'boolean'
        ];
    }

    protected function messages() {
        return [
            'formData.nik.required' => 'NIK wajib diisi.',
            'formData.nik.size' => 'NIK harus 16 digit.',
            'formData.nik.unique' => 'NIK sudah terdaftar dalam sistem.',
            'formData.no_kk_id.required' => 'No. KK wajib diisi.',
            'formData.no_kk_id.size' => 'No. KK harus 16 digit.',
            'formData.nama.required' => 'Nama lengkap wajib diisi.',
            'formData.nama.min' => 'Nama minimal 2 karakter.',
            'formData.nama.max' => 'Nama maksimal 100 karakter.',
            'formData.tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'formData.tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'formData.tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini.',
            'formData.jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'formData.golongan_darah.required' => 'Golongan darah wajib dipilih.',
            'formData.agama_id.required' => 'Agama wajib dipilih.',
            'formData.agama_id.exists' => 'Agama yang dipilih tidak valid.',
            'formData.status_perkawinan.required' => 'Status pernikahan wajib dipilih.',
            'formData.tanggal_perkawinan.required_if' => 'Tanggal perkawinan wajib diisi untuk status yang dipilih.',
            'formData.tanggal_perceraian.required_if' => 'Tanggal perceraian wajib diisi untuk status yang dipilih.',
            'formData.tanggal_perceraian.after' => 'Tanggal perceraian harus setelah tanggal perkawinan.',
            'formData.pendidikan_terakhir_id.required' => 'Pendidikan terakhir wajib dipilih.',
            'formData.hubungan_keluarga_id.required' => 'Hubungan dalam KK wajib dipilih.',
            'formData.nama_ayah.required' => 'Nama ayah wajib diisi.',
            'formData.nama_ibu.required' => 'Nama ibu wajib diisi.'
        ];
    }

    public function simpanDataWarga() {
        // Validasi data
        // $this->validate();
        // try {
            
            // Simpan ke database
            dd($this->formData);
            DataPribadi::create($this->formData);

            // session()->flash('message', 'Data warga berhasil disimpan!');
            // session()->flash('type', 'success');

            $this->closeTambahModal();
            $this->resetPage();

        // } catch (\Exception $e) {
        //     session()->flash('message', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        //     session()->flash('type', 'error');
        // }
    }

    public function render() {
        // TEMPORARY: For testing purposes, return dummy data
        // Comment this section when connecting to real database
        
        $dummyData = collect([
            (object) [
                'nik' => '3201010101010001',
                'no_kk_id' => '3210010101010001',
                'nama' => 'BUDI SANTOSA',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1975-02-15',
                'tempat_tanggal_lahir' => 'Bandung, 15 February 1975',
                'jenis_kelamin' => 'Laki-laki',
                'kewarganegaraan' => 'WNA',
                'penyandang_disabilitas' => true,
                'detail_disabilitas' => 'Tunanetra parsial (penglihatan terbatas)',
                'no_paspor' => 'A1234567',
                'no_kitap' => 'KITAP123456789',
                'nama_ayah' => 'SUDARSO',
                'nama_ibu' => 'SRI WAHYUNI',
                'status_perkawinan' => 'Kawin',
                'tanggal_perkawinan' => '1995-06-20',
            ],
            (object) [
                'nik' => '3201010101010002',
                'no_kk_id' => '3210010101010001',
                'nama' => 'SRI LESTARI',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1980-08-10',
                'tempat_tanggal_lahir' => 'Jakarta, 10 August 1980',
                'jenis_kelamin' => 'Perempuan',
                'kewarganegaraan' => 'WNI',
                'penyandang_disabilitas' => false,
                'detail_disabilitas' => null,
                'no_paspor' => null,
                'no_kitap' => null,
                'nama_ayah' => 'AHMAD WIJAYA',
                'nama_ibu' => 'SITI RAHAYU',
                'status_perkawinan' => 'Kawin',
                'tanggal_perkawinan' => '1995-06-20',
            ],
            (object) [
                'nik' => '3201010101010003',
                'no_kk_id' => '3210010101010001',
                'nama' => 'ANDI SANTOSA',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2000-03-25',
                'tempat_tanggal_lahir' => 'Bandung, 25 March 2000',
                'jenis_kelamin' => 'Laki-laki',
                'kewarganegaraan' => 'WNI',
                'penyandang_disabilitas' => false,
                'detail_disabilitas' => null,
                'no_paspor' => null,
                'no_kitap' => null,
                'nama_ayah' => 'BUDI SANTOSA',
                'nama_ibu' => 'SRI LESTARI',
                'status_perkawinan' => 'Belum Kawin',
                'tanggal_perkawinan' => null,
            ]
        ]);

        // Jika user tidak login
        if (!Auth::check()) {
            // Jika tidak ada pencarian NIK, return kosong
            if (empty($this->search)) {
                $dataWarga = new \Illuminate\Pagination\LengthAwarePaginator(
                    collect([]),
                    0,
                    10,
                    1,
                    ['path' => request()->url()]
                );
                
                return view('livewire.data-warga-index', compact('dataWarga'));
            }
            
            // Hanya cari berdasarkan NIK exact match
            $dummyData = $dummyData->filter(function($item) {
                return $item->nik === $this->search;
            });
        } else {
            // Jika user login (admin), tampilkan semua filtering seperti biasa
            if (!empty($this->search)) {
                $dummyData = $dummyData->filter(function($item) {
                    return str_contains(strtolower($item->nama), strtolower($this->search)) ||
                           str_contains($item->nik, $this->search) ||
                           str_contains($item->no_kk_id, $this->search);
                });
            }
        }

        // Convert to paginated collection
        $dataWarga = new \Illuminate\Pagination\LengthAwarePaginator(
            $dummyData->values(),
            $dummyData->count(),
            10,
            1,
            ['path' => request()->url()]
        );

        // Data untuk options (hanya untuk admin)
        if (Auth::check()) {
            $rwOptions = ['01' => '01', '02' => '02', '03' => '03'];
            $rtOptions = ['001' => '001', '002' => '002', '003' => '003'];
            $pendidikanOptions = [
                '1' => 'Tidak/Belum Sekolah',
                '2' => 'SD',
                '3' => 'SMP', 
                '4' => 'SMA',
                '5' => 'D3',
                '6' => 'S1',
                '7' => 'S2',
                '8' => 'S3'
            ];
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

            return view('livewire.data-warga-index', compact(
                'dataWarga', 
                'rwOptions', 
                'rtOptions', 
                'pendidikanOptions', 
                'statusPernikahanOptions', 
                'tagOptions'
            ));
        } else {
            // Untuk user tidak login, hanya return data warga
            return view('livewire.data-warga-index', compact('dataWarga'));
        }
        
        // COMMENT OUT ORIGINAL DATABASE CODE FOR NOW
        /*
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
        */
    }
}