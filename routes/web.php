<?php

use App\Livewire\Dashboard;
use App\Livewire\DataIndividuDetail;
use App\Livewire\DataWargaIndex;
use App\Livewire\ManajemenAkun;
use Illuminate\Support\Facades\Route;

// Login route
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Group all routes under a layout (assuming 'app' layout)
Route::middleware(['web', 'checkUserStatus'])->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::get('/data-warga', DataWargaIndex::class)->name('data-warga.index');
    Route::get('/data-warga/{id}', DataIndividuDetail::class)->name('data-warga.show');

    
    Route::get('/manajemen-akun', ManajemenAkun::class)->middleware(['permission:View Management'])->name('manajemen-akun');
});

require __DIR__.'/auth.php';
