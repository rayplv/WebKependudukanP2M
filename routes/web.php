<?php

use App\Livewire\Dashboard;
use App\Livewire\DataIndividuDetail;
use App\Livewire\DataWargaIndex;
use App\Livewire\ManajemenAkun;
use App\Livewire\TambahAkunBaru;
use App\Livewire\TambahDataWarga;
use Illuminate\Support\Facades\Route;

// Login route
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Group all routes under a layout (assuming 'app' layout)
Route::middleware(['web'])->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');

    Route::get('/data-warga', DataWargaIndex::class)->name('data-warga.index');
    Route::get('/data-warga/create', TambahDataWarga::class)->name('data-warga.create');
    Route::get('/data-warga/{id}', DataIndividuDetail::class)->name('data-warga.show');

    Route::get('/manajemen-akun', ManajemenAkun::class)->name('manajemen-akun');
    Route::get('/manajemen-akun/create', TambahAkunBaru::class)->name('manajemen-akun.create');
});
