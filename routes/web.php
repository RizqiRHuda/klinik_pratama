<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PasienController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/', function () {
    return redirect()->route('login');
});

// Route untuk proses login & logout
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/dashboard/super_admin', function () {
        return view('layouts.app');
    })->name('dashboard.super_admin');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard/admin', function () {
        return view('layouts.app');
    })->name('dashboard.admin');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard/user', function () {
        return view('layouts.app');
    })->name('dashboard.user');
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('obat')->group(function () {
        Route::get('/page-obat', [ObatController::class, 'index'])->name('obat.page-obat');
        Route::post('/simpan-obat', [ObatController::class, 'simpanObat'])->name('obat.simpan-obat');
        Route::get('/get-obat', [ObatController::class, 'getObat'])->name('obat.get-obat');
        Route::post('/import-obat', [ObatController::class, 'importObat'])->name('obat.import-obat');
    });

    Route::prefix('pasien')->group(function () {
        Route::get('/page-pasien', [PasienController::class, 'index'])->name('pasien.page-pasien');
        Route::post('/simpan-data', [PasienController::class, 'simpan'])->name('pasien.simpan-data');
        Route::get('/data-pasien', [PasienController::class, 'getDataPasien'])->name('pasien.data-pasien');
        Route::get('edit/{id}', [PasienController::class, 'edit'])->name('pasien.edit-pasien');
        Route::put('update/{id}', [PasienController::class, 'update'])->name('pasien.update-pasien');
        Route::delete('hapus/{id}', [PasienController::class, 'destroy'])->name('pasien.hapus-pasien');

    });
});
