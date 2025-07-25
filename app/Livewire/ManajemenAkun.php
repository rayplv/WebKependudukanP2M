<?php
namespace App\Livewire;

use Livewire\Component;

class ManajemenAkun extends Component {
    // For backend:
    // protected $listeners = ['accountAdded' => '$refresh'];

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
