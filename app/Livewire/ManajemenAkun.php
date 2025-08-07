<?php
namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class ManajemenAkun extends Component {
    public $showTambahModal = false;
    public $showEditModal = false;
    public $UserId;
    public $formData = [
        'nama' => '',
        'email' => '',
        'password' => '',
        'password_confirmation' => '',
        'role' => ''
    ];
    public $editFormData = [];

    public function openTambahModal() {
        $this->showTambahModal = true;
        $this->resetFormData();
    }

    public function closeTambahModal() {
        $this->showTambahModal = false;
        $this->resetFormData();
    }

    public function openEditModal($id) {
        $this->showEditModal = true;
        $this->UserId = $id;
        $this->editFormData = User::find($id)->toArray();
    }

    public function closeEditModal() {
        $this->showEditModal = false;
        $this->UserId = null;
        $this->resetEditFormData();
    }

    public function resetFormData() {
        $this->formData = [
            'nama' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => '',
        ];
    }
    public function resetEditFormData() {
        $this->editFormData = [];
    }

    public function simpanAkun() {
        // Validasi data
        $this->validate([
            'formData.name' => 'required|string|max:255',
            'formData.email' => 'required|email|max:255|unique:users,email',
            'formData.password' => 'required|string|min:8',
            'formData.password_confirmation' => 'required|same:formData.password',
        ], [
            'formData.name.required' => 'Nama wajib diisi',
            'formData.email.required' => 'Email wajib diisi',
            'formData.email.email' => 'Format email tidak valid',
            'formData.password.required' => 'Password wajib diisi',
            'formData.password.min' => 'Password minimal 8 karakter',
            'formData.password_confirmation.required' => 'Konfirmasi password wajib diisi',
            'formData.password_confirmation.same' => 'Konfirmasi password tidak sama',
        ]);

        // Simpan data akun baru
        $this->formData['role_id'] = '2';

        User::create($this->formData);

        // Untuk frontend: tampilkan pesan sukses
        session()->flash('message', 'Akun baru berhasil dibuat!');
        session()->flash('type', 'success');

        $this->resetFormData();
        $this->closeTambahModal();
    }

    public function render() {
        $query = User::with('role');

        $accounts = $query->get();
        return view('livewire.manajemen-akun', compact('accounts'));
    }

    public function editAccount() {
        // Validate data
        $validationRules = [
            'editFormData.name' => 'required|string|max:255',
            'editFormData.email' => 'required|email|max:255|unique:users,email,'.$this->UserId,
        ];
        
        $validationMessages = [
            'editFormData.name.required' => 'Nama wajib diisi',
            'editFormData.email.required' => 'Email wajib diisi',
            'editFormData.email.email' => 'Format email tidak valid',
            'editFormData.email.unique' => 'Email sudah digunakan',
        ];
        
        $validationRules['editFormData.password'] = 'string|min:8';
        $validationRules['editFormData.password_confirmation'] = 'required|same:editFormData.password';
        
        $validationMessages['editFormData.password.min'] = 'Password minimal 8 karakter';
        $validationMessages['editFormData.password_confirmation.required'] = 'Konfirmasi password wajib diisi';
        $validationMessages['editFormData.password_confirmation.same'] = 'Konfirmasi password tidak sama';
        
        $this->validate($validationRules, $validationMessages);

        $akunUser = User::findOrFail($this->UserId);
        
        $akunUser->update($this->editFormData);

        $this->closeEditModal();

        session()->flash('message', 'Data berhasil di Update.');
        session()->flash('type', 'success');
    }

    public function deleteAccount($id) {
        try {
            // Find and delete the user
            $user = User::findOrFail($id);
            $user->delete();

            session()->flash('message', 'Data pengguna berhasil dihapus!');
            session()->flash('type', 'success');
            
            return redirect()->route('manajemen-akun');
        } catch (\Exception $e) {
            session()->flash('message', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
            session()->flash('type', 'error');
        }
    }
}
