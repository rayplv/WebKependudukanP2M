<?php
namespace App\Livewire;

use Livewire\Component;

// For backend: for password hashing

class TambahAkunBaru extends Component {
    public $namaAkun;
    public $email;
    public $kataSandi;
    public $role = 'aktif'; // Default role, adjust as needed

    protected $rules = [
        'namaAkun'  => 'required|string|max:255',
        'email'     => 'required|email|unique:users,email', // For backend: this rule already check uniqueness
        'kataSandi' => 'required|string|min:8',
        'role'      => 'required|string|in:aktif,suspended', // Adjust roles as per your application
    ];

    public function render() {
        $roleOptions = ['aktif' => 'Aktif', 'suspended' => 'Suspended'];
        return view('livewire.tambah-akun-baru', compact('roleOptions'));
    }

    public function buatAkunBaru() {
        $this->validate();

        // For backend:
        // User::create([
        //     'name' => $this->namaAkun,
        //     'email' => $this->email,
        //     'password' => Hash::make($this->kataSandi),
        //     'role' => $this->role,
        // ]);

        session()->flash('message', 'Akun baru berhasil dibuat!');
        $this->reset(); // Clear form fields

        // $this->dispatch('accountAdded'); // Emit event to refresh account list
        // return redirect()->route('manajemen-akun'); // For backend: redirect to account list
    }

    public function cancel() {
        return redirect()->route('manajemen-akun');
    }
}
