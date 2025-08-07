<?php
namespace App\Livewire;

use App\Models\DataPribadi;
use App\Models\DataKeluarga;
use App\Models\Agama;
use App\Models\PendidikanTerakhir;
use App\Models\Pekerjaan;
use App\Models\HubunganKeluarga;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class DataIndividuDetail extends Component {
    public $residentId;
    public $resident;
    public $originalKKId; // To track if KK ID has changed
    
    public $kkExists = null;
    public $checkingKK = false;

    // For edit modal
    public $showEditModal = false;
    public $editFormData = [];
    public $kkData = [];
    
    public function mount($id) {
        $this->residentId = $id;
        
        // Fetch data with eager loading of all required relationships
        $query = DataPribadi::with([
            'dataKeluarga',
            'agama',
            'pendidikanTerakhir',
            'pekerjaan',
            'hubunganKeluarga'
        ]);

        // Get the resident data
        $this->resident = $query->findOrFail($id);

        // Get family members that belong to the same KK
        $familyMembers = DataPribadi::where('no_kk_id', $this->resident->no_kk_id)
            ->with('hubunganKeluarga')
            ->get()
            ->map(function ($member) {
                return (object)[
                    'hubungan' => $member->hubunganKeluarga->nama ?? 'Unknown',
                    'nama_anggota' => $member->nama,
                    'nik' => $member->nik
                ];
            });

        $this->resident->keluarga_dalam_kk = $familyMembers;
    }

    public function render() {
        // Get data for form dropdown options
        $agamaOptions = Agama::pluck('nama', 'id')->toArray();
        $pendidikanOptions = PendidikanTerakhir::pluck('nama', 'id')->toArray();
        $pekerjaanOptions = Pekerjaan::pluck('nama', 'id')->toArray();
        $hubunganKeluargaOptions = HubunganKeluarga::pluck('nama', 'id')->toArray();
        
        return view('livewire.data-individu-detail', compact(
            'agamaOptions',
            'pendidikanOptions',
            'pekerjaanOptions',
            'hubunganKeluargaOptions'
        ));
    }

    public function editData() {
        // Check permissions before allowing edit
        if (!Auth::check() || !Auth::user()->hasPermission('edit-residents')) {
            session()->flash('message', 'Anda tidak memiliki izin untuk mengedit data.');
            session()->flash('type', 'error');
            return;
        }
        
        // Store original KK ID for comparison later
        $this->originalKKId = $this->resident->no_kk_id;
        
        // mengambil data anggota keluarga yang terkait dengan KK ini, karena akan menghilang jika membuka modal edit
        $familyMembers = DataPribadi::where('no_kk_id', $this->resident->no_kk_id)
        ->with('hubunganKeluarga')
        ->get()
        ->map(function ($member) {
            return (object)[
                'hubungan' => $member->hubunganKeluarga->nama ?? 'Unknown',
                'nama_anggota' => $member->nama,
                'nik' => $member->nik
            ];
        });
        $this->resident->keluarga_dalam_kk = $familyMembers;
        
        // Initialize edit form data with current resident data
        $this->editFormData = $this->resident->toArray();
        
        // Handle penyandang_disabilitas checkbox
        $this->editFormData['penyandang_disabilitas_check'] = !empty($this->editFormData['penyandang_disabilitas']) ? true : false;


        // Pastikan format tanggal_lahir sesuai input type="date"
        if (!empty($this->resident->tanggal_lahir)) {
            $this->editFormData['tanggal_lahir'] = \Carbon\Carbon::parse($this->resident->tanggal_lahir)->format('Y-m-d');
        }
        
        // Load KK data
        $kk = DataKeluarga::find($this->resident->no_kk_id);
        if ($kk) {
            $this->kkData = $kk->toArray();
            // Pastikan format tanggal_dikeluarkan sesuai input type="date"
            if (!empty($kk->tanggal_dikeluarkan)) {
                $this->kkData['tanggal_dikeluarkan'] = \Carbon\Carbon::parse($kk->tanggal_dikeluarkan)->format('Y-m-d');
            }
        } else {
            $this->kkData = [];
        }
            
            $kk = DataKeluarga::find($this->editFormData['no_kk_id']);
            $this->kkExists = $kk ? true : null;

            // Show edit modal
            $this->showEditModal = true;
        }
    
    public function checkKKExists()
    {
        $noKK = $this->editFormData['no_kk_id'] ?? '';
        
        if (strlen($noKK) !== 16) {
            session()->flash('message', 'No. KK harus 16 digit.');
            return;
        }
        
        $this->checkingKK = true;
        
        $kk = DataKeluarga::find($noKK);
        
        if ($kk) {
            $this->kkExists = true;
            // Load KK data
            $this->kkData = [
                'alamat' => $kk->alamat,
                'rt' => $kk->rt,
                'rw' => $kk->rw,
                'tanggal_dikeluarkan' => $kk->tanggal_dikeluarkan ? 
                    \Carbon\Carbon::parse($kk->tanggal_dikeluarkan)->format('Y-m-d') : null
            ];
        } else {
            $this->kkExists = false;
            // Reset KK data for new input
            $this->kkData = [
                'alamat' => '',
                'rt' => '',
                'rw' => '',
                'tanggal_dikeluarkan' => ''
            ];
        }
    $this->checkingKK = false;
}
    
    public function closeEditModal() {
        $this->showEditModal = false;
        $this->kkExists = null;
        $this->checkingKK = false;

         // mengambil data anggota keluarga yang terkait dengan KK ini, karena akan menghilang jika menutup modal edit
        $familyMembers = DataPribadi::where('no_kk_id', $this->resident->no_kk_id)
        ->with('hubunganKeluarga')
        ->get()
        ->map(function ($member) {
            return (object)[
                'hubungan' => $member->hubunganKeluarga->nama ?? 'Unknown',
                'nama_anggota' => $member->nama,
                'nik' => $member->nik
            ];
        });
        $this->resident->keluarga_dalam_kk = $familyMembers;
        $this->resetValidation();
    }
    
    protected $rules = [
        'editFormData.nik' => 'required|digits:16',
        'editFormData.no_kk_id' => 'required|digits:16',
        'editFormData.nama' => 'required|string|min:3',
        'editFormData.tempat_lahir' => 'required|string|min:2',
        'editFormData.tanggal_lahir' => 'required|date',
        'editFormData.jenis_kelamin' => 'required|in:LAKI-LAKI,PEREMPUAN',
        'editFormData.agama_id' => 'required|exists:agama,id',
        'editFormData.status_perkawinan' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
        'editFormData.pendidikan_terakhir_id' => 'required|exists:pendidikan_terakhir,id',
        'editFormData.pekerjaan_id' => 'required|exists:pekerjaan,id',
        'editFormData.hubungan_keluarga_id' => 'required|exists:hubungan_keluarga,id',
        'editFormData.kewarganegaraan' => 'required|in:WNI,WNA',
        'editFormData.golongan_darah' => 'required|in:A,B,AB,O',
        'editFormData.no_paspor' => 'nullable|string|size:8',
        'editFormData.no_kitap' => 'nullable|string|size:11',
        'editFormData.nama_ayah' => 'required|string|min:3',
        'editFormData.nama_ibu' => 'required|string|min:3',
        'kkData.alamat' => 'required|string|min:5',
        'kkData.rt' => 'required|string|min:1|max:3',
        'kkData.rw' => 'required|string|min:1|max:3',
    ];
    
    public function updateDataWarga() {
        // Special validation for the unique NIK (except the current resident)
        $uniqueNikRule = 'required|digits:16|unique:data_pribadi,nik,' . $this->residentId . ',nik';
        $this->validate(array_merge($this->rules, [
            'editFormData.nik' => $uniqueNikRule
        ]));
        
        try {
            // Additional validations based on specific conditions
            if($this->editFormData['status_perkawinan'] === 'Kawin'){
                $this->validate([
                    'editFormData.tanggal_perkawinan' => 'required|date',
                ]);
            } else if($this->editFormData['status_perkawinan'] === 'Cerai Hidup' || $this->editFormData['status_perkawinan'] === 'Cerai Mati'){
                $this->validate([
                    'editFormData.tanggal_perkawinan' => 'required|date',
                    'editFormData.tanggal_perceraian' => 'required|date',
                ]);
            }

            if($this->editFormData['penyandang_disabilitas_check'] === true){
                $this->validate([
                    'editFormData.penyandang_disabilitas' => 'required|string|min:3',
                ]);
            } else {
                $this->editFormData['penyandang_disabilitas'] = null;
            }

            // Handle empty values
            foreach ($this->editFormData as $key => $value) {
                if ($value === '') {
                    $this->editFormData[$key] = null;
                }
            }

            // Handle status pernikahan
            if($this->editFormData['status_perkawinan'] === 'Belum Kawin'){
                $this->editFormData['tanggal_perkawinan'] = null;
                $this->editFormData['tanggal_perceraian'] = null;
            } else if($this->editFormData['status_perkawinan'] === 'Kawin'){
                $this->editFormData['tanggal_perceraian'] = null;
            }
            
            $oldNik = $this->resident->nik;
            $newNik = $this->editFormData['nik'];
            
            // Handle KK changes
            $noKK = $this->editFormData['no_kk_id'];
            $kkChanged = $noKK !== $this->originalKKId;
            
            // Check if KK exists
            $kk = DataKeluarga::find($noKK);
            
            if (!$kk) {
                // Create new KK if it doesn't exist
                DataKeluarga::create([
                    'no_kk' => $noKK,
                    'alamat' => $this->kkData['alamat'],
                    'rt' => $this->kkData['rt'],
                    'rw' => $this->kkData['rw'],
                    'tanggal_dikeluarkan' => $this->kkData['tanggal_dikeluarkan'] ?: null,
                ]);
            } else if (!$kkChanged) {
                // Update existing KK if KK ID wasn't changed
                $kk->update([
                    'alamat' => $this->kkData['alamat'],
                    'rt' => $this->kkData['rt'],
                    'rw' => $this->kkData['rw'],
                    'tanggal_dikeluarkan' => $this->kkData['tanggal_dikeluarkan'] ?: $kk->tanggal_dikeluarkan,
                ]);
            }
            
            // Update resident data
            $resident = DataPribadi::findOrFail($this->residentId);
            $resident->update($this->editFormData);
            
            session()->flash('message', 'Data warga berhasil diperbarui!');
            session()->flash('type', 'success');
            
            // Close modal
            $this->closeEditModal();
            
            // If NIK changed, redirect to the new URL
            if ($oldNik !== $newNik) {
                return redirect()->route('data-warga.show', $newNik);
            }
            
            // Otherwise just reload the current data
            $this->mount($this->residentId);
            
        } catch (\Exception $e) {
            session()->flash('message', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
            session()->flash('type', 'error');
        }
    }

    public function hapusData() {
        // Check permissions before allowing delete
        if (!Auth::check() || !Auth::user()->hasPermission('delete-residents')) {
            session()->flash('message', 'Anda tidak memiliki izin untuk menghapus data.');
            session()->flash('type', 'error');
            return;
        }

        try {
            // Find and delete the resident
            $resident = DataPribadi::findOrFail($this->residentId);
            $resident->delete();
            
            session()->flash('message', 'Data warga berhasil dihapus!');
            session()->flash('type', 'success');
            
            return redirect()->route('data-warga.index');
        } catch (\Exception $e) {
            session()->flash('message', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
            session()->flash('type', 'error');
        }
    }
}