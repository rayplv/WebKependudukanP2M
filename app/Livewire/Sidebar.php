<?php
namespace App\Livewire;

use Livewire\Component;

class Sidebar extends Component {
    public $currentRoute;
    public $sidebarOpen = true; // Initial state for sidebar

    public function mount() {
        $this->currentRoute = request()->route()->getName();
    }

    public function toggleSidebar() {
        $this->sidebarOpen = ! $this->sidebarOpen;
        $this->dispatch('sidebar-toggled');
    }

    public function render() {
        return view('livewire.sidebar');
    }

    // For backend:
    // public function logout()
    // {
    //     Auth::logout();
    //     return redirect('/');
    // }
}
