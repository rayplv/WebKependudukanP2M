<?php

use App\Livewire\Dashboard;
use App\Livewire\DataIndividuDetail;
use App\Livewire\DataWargaIndex;
use App\Livewire\ManajemenAkun;
use App\Livewire\TambahAkunBaru;
use App\Livewire\TambahDataWarga;
use App\Http\Controllers\ProfileController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/test', function () {
    return view('permissionTest');
    // abort(403, 'page not found'); // Menampilkan halaman error 403
})->middleware(['auth', 'verified', 'permission:View Dashboard'])->name('test');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
