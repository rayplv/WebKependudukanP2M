<?php
namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

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
        if (!Auth::check() || !Auth::user()->hasPermission('add-users')) {
            session()->flash('message', 'Anda tidak memiliki izin untuk menambah data.');
            session()->flash('type', 'error');
            return;
        }
        $this->showTambahModal = true;
        $this->resetFormData();
    }

    public function closeTambahModal() {
        $this->showTambahModal = false;
        $this->resetFormData();
    }

    public function openEditModal($id) {
        if (!Auth::check() || !Auth::user()->hasPermission('edit-users')) {
            session()->flash('message', 'Anda tidak memiliki izin untuk mengedit data.');
            session()->flash('type', 'error');
            return;
        }
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
        if (!Auth::check() || !Auth::user()->hasPermission('add-users')) {
            session()->flash('message', 'Anda tidak memiliki izin untuk menambah data.');
            session()->flash('type', 'error');
            return;
        }
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
        if (!Auth::check() || !Auth::user()->hasPermission('edit-users')) {
            session()->flash('message', 'Anda tidak memiliki izin untuk mengedit data.');
            session()->flash('type', 'error');
            return;
        }
        // Validate data
        $validationRules = [
            'editFormData.name' => 'required|string|max:255',
            'editFormData.email' => 'required|email|max:255|unique:users,email,'.$this->UserId,
            'editFormData.password' => 'required|string|min:8',
            'editFormData.password_confirmation' => 'required|same:editFormData.password',
        ];
        
        $validationMessages = [
            'editFormData.name.required' => 'Nama wajib diisi',
            'editFormData.email.required' => 'Email wajib diisi',
            'editFormData.email.email' => 'Format email tidak valid',
            'editFormData.email.unique' => 'Email sudah digunakan',
            'editFormData.password.min' => 'Password minimal 8 karakter',
            'editFormData.password_confirmation.required' => 'Konfirmasi password wajib diisi',
            'editFormData.password_confirmation.same' => 'Konfirmasi password tidak sama',
        ];
        
        
        $this->validate($validationRules, $validationMessages);

        $akunUser = User::findOrFail($this->UserId);
        
        $akunUser->update($this->editFormData);

        $this->closeEditModal();

        session()->flash('message', 'Data berhasil di Update.');
        session()->flash('type', 'success');
    }

    public function deleteAccount($id) {
        if (!Auth::check() || !Auth::user()->hasPermission('delete-users')) {
            session()->flash('message', 'Anda tidak memiliki izin untuk menghapus data.');
            session()->flash('type', 'error');
            return;
        }
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

    public function suspendAccount($id) {
        if (!Auth::check() || !Auth::user()->hasPermission('status-users')) {
            session()->flash('message', 'Anda tidak memiliki izin untuk mengedit status data.');
            session()->flash('type', 'error');
            return;
        }
        try {
            // Find the user and update their status
            $user = User::findOrFail($id);
            $user->status = 'suspended';
            $user->save();

            session()->flash('message', 'Akun berhasil disuspend!');
            session()->flash('type', 'success');
        } catch (\Exception $e) {
            session()->flash('message', 'Terjadi kesalahan saat men-suspend akun: ' . $e->getMessage());
            session()->flash('type', 'error');
        }
    }
    public function activateAccount($id) {
        if (!Auth::check() || !Auth::user()->hasPermission('status-users')) {
            session()->flash('message', 'Anda tidak memiliki izin untuk mengedit status data.');
            session()->flash('type', 'error');
            return;
        }
        try {
            // Find the user and update their status
            $user = User::findOrFail($id);
            $user->status = 'active';
            $user->save();

            session()->flash('message', 'Akun berhasil diaktifkan!');
            session()->flash('type', 'success');
        } catch (\Exception $e) {
            session()->flash('message', 'Terjadi kesalahan saat mengaktifkan akun: ' . $e->getMessage());
            session()->flash('type', 'error');
        }
    }
}
