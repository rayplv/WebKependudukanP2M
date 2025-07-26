<?php
namespace App\Livewire;

use Livewire\Component;

class ManajemenAkun extends Component {
    // For backend:
    // protected $listeners = ['accountAdded' => '$refresh'];

    // Modal properties
    public $showTambahModal = false;
    public $formData = [
        'nama' => '',
        'email' => '',
        'password' => '',
        'password_confirmation' => '',
        'role' => ''
    ];

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
            'nama' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => '',
            'role' => ''
        ];
    }

    public function simpanAkun() {
        // Validasi data
        $this->validate([
            'formData.nama' => 'required|string|max:255',
            'formData.email' => 'required|email|max:255',
            'formData.password' => 'required|string|min:8',
            'formData.password_confirmation' => 'required|same:formData.password',
            'formData.role' => 'required|string'
        ], [
            'formData.nama.required' => 'Nama wajib diisi',
            'formData.email.required' => 'Email wajib diisi',
            'formData.email.email' => 'Format email tidak valid',
            'formData.password.required' => 'Password wajib diisi',
            'formData.password.min' => 'Password minimal 8 karakter',
            'formData.password_confirmation.required' => 'Konfirmasi password wajib diisi',
            'formData.password_confirmation.same' => 'Konfirmasi password tidak sama',
            'formData.role.required' => 'Role wajib dipilih'
        ]);

        // Untuk backend: simpan ke database
        // User::create([
        //     'name' => $this->formData['nama'],
        //     'email' => $this->formData['email'],
        //     'password' => Hash::make($this->formData['password']),
        //     'role' => $this->formData['role']
        // ]);

        // Untuk frontend: tampilkan pesan sukses
        session()->flash('message', 'Akun baru berhasil dibuat!');
        session()->flash('type', 'success');

        $this->closeTambahModal();
    }

    public function render() {
        // For backend:
        // $accounts = User::whereIn('role', ['Petugas A', 'Petugas B'])->get(); // Example: fetch user accounts with specific roles

        // Dummy data for frontend
        $accounts = collect([
            (object) ['id' => 1, 'nama' => 'Petugas A', 'email' => 'admindata@mail.com', 'role' => 'aktif'],
            (object) ['id' => 2, 'nama' => 'Petugas B', 'email' => 'adminverif@mail.com', 'role' => 'suspended'],
        ]);

        return view('livewire.manajemen-akun', compact('accounts'));
    }

    public function editAccount($id) {
        // For backend: Redirect to edit account page
        // return redirect()->route('manajemen-akun.edit', $id);
        // For frontend:
        session()->flash('message', "Fitur edit akun ID: {$id} akan diimplementasikan oleh backend.");
    }

    public function deleteAccount($id) {
        // For backend: Delete account logic, show confirmation
        // if (confirm('Are you sure you want to delete this account?')) {
        //     User::destroy($id);
        //     session()->flash('message', 'Akun berhasil dihapus.');
        // }
        // For frontend:
        session()->flash('message', "Fitur hapus akun ID: {$id} akan diimplementasikan oleh backend.");
    }
}
