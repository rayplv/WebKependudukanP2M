<?php
namespace App\Livewire;

use Livewire\Component;

class TambahDataWarga extends Component {
    public $namaLengkap;
    public $nik;
    public $tempatLahir;
    public $tanggalLahir;
    public $noTelpWhatsapp;
    public $noKeluarga;
    public $hubunganDalamKK;
    public $alamat;
    public $rt;
    public $rw;
    public $jenisKelamin;
    public $golDarah;
    public $agama;
    public $statusPernikahan;
    public $jenjangPendidikan;
    public $pekerjaan;
    public $penyandangDisabilitas = false;
    public $penyakitDisabilitas;

    protected $rules = [
        'namaLengkap'           => 'required|string|max:255',
        'nik'                   => 'required|string|digits:16', // For backend: add "|unique:residents,nik" for database uniqueness check
        'tempatLahir'           => 'required|string|max:255|not_in:',
        'tanggalLahir'          => 'required|date',
        'noTelpWhatsapp'        => 'nullable|string|max:20',
        'noKeluarga'            => 'required|string|digits:16',
        'hubunganDalamKK'       => 'required|string|max:50|not_in:',
        'alamat'                => 'required|string|max:255',
        'rt'                    => 'required|string|max:10|not_in:',
        'rw'                    => 'required|string|max:10|not_in:',
        'jenisKelamin'          => 'required|string|in:Laki-laki,Perempuan',
        'golDarah'              => 'nullable|string|max:5',
        'agama'                 => 'required|string|max:50|not_in:',
        'statusPernikahan'      => 'required|string|max:50|not_in:',
        'jenjangPendidikan'     => 'required|string|max:50|not_in:',
        'pekerjaan'             => 'required|string|max:255|not_in:',
        'penyandangDisabilitas' => 'boolean',
        'penyakitDisabilitas'   => 'nullable|string|max:255|required_if:penyandangDisabilitas,true',
    ];

    public function render() {
        $kotaOptions              = ['' => '-- Pilih Tempat Lahir --'] + ['Bogor' => 'Bogor', 'Jakarta' => 'Jakarta', 'Bandung' => 'Bandung'];
        $hubunganOptions          = ['' => '-- Pilih Hubungan --'] + ['Kepala Keluarga' => 'Kepala Keluarga', 'Istri' => 'Istri', 'Anak' => 'Anak', 'Lainnya' => 'Lainnya'];
        $rtRwOptions              = ['' => '-- Pilih --'] + ['01' => '01', '02' => '02', '03' => '03']; // Example options
        $jenisKelaminOptions      = ['' => '-- Pilih Jenis Kelamin --'] + ['Laki-laki' => 'Laki-laki', 'Perempuan' => 'Perempuan'];
        $golDarahOptions          = ['' => '-- Pilih Golongan Darah --'] + ['A' => 'A', 'B' => 'B', 'AB' => 'AB', 'O' => 'O', '-' => '-'];
        $agamaOptions             = ['' => '-- Pilih Agama --'] + ['Islam' => 'Islam', 'Kristen' => 'Kristen', 'Katolik' => 'Katolik', 'Hindu' => 'Hindu', 'Buddha' => 'Buddha', 'Konghucu' => 'Konghucu'];
        $statusPernikahanOptions  = ['' => '-- Pilih Status --'] + ['Belum Menikah' => 'Belum Menikah', 'Menikah' => 'Menikah', 'Cerai Hidup' => 'Cerai Hidup', 'Cerai Mati' => 'Cerai Mati'];
        $jenjangPendidikanOptions = ['' => '-- Pilih Pendidikan --'] + ['Tidak Sekolah' => 'Tidak Sekolah', 'SD' => 'SD', 'SMP' => 'SMP', 'SMA' => 'SMA', 'D1' => 'D1', 'D2' => 'D2', 'D3' => 'D3', 'S1' => 'S1', 'S2' => 'S2', 'S3' => 'S3'];
        $pekerjaanOptions         = ['' => '-- Pilih Pekerjaan --'] + ['PNS' => 'PNS', 'Swasta' => 'Swasta', 'Wiraswasta' => 'Wiraswasta', 'Pelajar/Mahasiswa' => 'Pelajar/Mahasiswa', 'Tidak Bekerja' => 'Tidak Bekerja'];

        return view('livewire.tambah-data-warga', compact(
            'kotaOptions', 'hubunganOptions', 'rtRwOptions',
            'jenisKelaminOptions', 'golDarahOptions', 'agamaOptions',
            'statusPernikahanOptions', 'jenjangPendidikanOptions', 'pekerjaanOptions'
        ));
    }

    public function submitForm() {
        $this->validate();

        // TODO: For backend team - implement database storage
        // 1. Create 'residents' table with appropriate columns
        // 2. Create Resident model
        // 3. Uncomment and implement the penduduk/resident addition, something like this:

        /*
        Resident::create([
            'nama_lengkap' => $this->namaLengkap,
            'nik' => $this->nik,
            'tempat_lahir' => $this->tempatLahir,
            'tanggal_lahir' => $this->tanggalLahir,
            'no_telp_whatsapp' => $this->noTelpWhatsapp,
            'no_kk' => $this->noKeluarga,
            'hubungan_dalam_kk' => $this->hubunganDalamKK,
            'alamat' => $this->alamat,
            'rt' => $this->rt,
            'rw' => $this->rw,
            'jenis_kelamin' => $this->jenisKelamin,
            'gol_darah' => $this->golDarah,
            'agama' => $this->agama,
            'status_pernikahan' => $this->statusPernikahan,
            'jenjang_pendidikan' => $this->jenjangPendidikan,
            'pekerjaan' => $this->pekerjaan,
            'penyandang_disabilitas' => $this->penyandangDisabilitas,
            'penyakit_disabilitas' => $this->penyakitDisabilitas,
        ]);
        */

        // TODO: For backend team - implement proper redirect after successful save
        // return redirect()->route('data-warga.index');

        session()->flash('message', 'Data warga berhasil ditambahkan!');
        $this->reset(); // Clear form fields
    }
}
