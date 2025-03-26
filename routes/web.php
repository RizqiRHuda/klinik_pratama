<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\TerapiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::get('/', function () {
    return redirect()->route('login');
});

// Route untuk proses login & logout
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/dashboard/super_admin', [DashboardController::class, 'index'])->name('dashboard.super_admin');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard/admin', [DashboardController::class, 'index'])->name('dashboard.admin');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    // Route::get('/dashboard/user', function () {
    //     return view('layouts.app');
    // })->name('dashboard.user');
    Route::get('/dashboard/user', [DashboardController::class, 'index'])->name('dashboard.user');
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('obat')->group(function () {
        Route::get('/page-obat', [ObatController::class, 'index'])->name('obat.page-obat');
        Route::post('/simpan-obat', [ObatController::class, 'simpanObat'])->name('obat.simpan-obat');
        Route::get('/get-obat', [ObatController::class, 'getObat'])->name('obat.get-obat');
        Route::post('/import-obat', [ObatController::class, 'importObat'])->name('obat.import-obat');
        Route::get('edit/{id}', [ObatController::class, 'edit'])->name('obat.edit-obat');
        Route::put('update/{id}', [ObatController::class, 'update'])->name('obat.update-obat');
        Route::delete('hapus/{id}', [ObatController::class, 'destroy'])->name('obat.hapus-obat');
        Route::get('/export-obat', [ObatController::class, 'export'])->name('obat.export-obat');
    });

    Route::prefix('pasien')->group(function () {
        Route::get('/page-pasien', [PasienController::class, 'index'])->name('pasien.page-pasien');
        Route::post('/simpan-data', [PasienController::class, 'simpan'])->name('pasien.simpan-data');
        Route::get('/data-pasien', [PasienController::class, 'getDataPasien'])->name('pasien.data-pasien');
        Route::get('edit/{id}', [PasienController::class, 'edit'])->name('pasien.edit-pasien');
        Route::put('update/{id}', [PasienController::class, 'update'])->name('pasien.update-pasien');
        Route::delete('hapus/{id}', [PasienController::class, 'destroy'])->name('pasien.hapus-pasien');
    });

    Route::prefix('terapi')->group(function () {
        Route::get('/page-terapi', [TerapiController::class, 'index'])->name('terapi.page-terapi');
        Route::get('/cari-pasien/{no_rm}', [TerapiController::class, 'cariPasien'])->name('terapi.cari-pasien');
        Route::get('/table-terapi', [TerapiController::class, 'indexRiwayat'])->name('terapi.table-terapi');
        Route::get('/obat-terapi', [TerapiController::class, 'getObat'])->name('terapi.obat-terapi');
        Route::post('/simpan-terapi', [TerapiController::class, 'simpan'])->name('terapi.simpan-terapi');
        Route::get('/get-pasienTerapi', [TerapiController::class, 'getPasien'])->name('terapi.get-pasienTerapi');
        Route::get('/laporanTerapi', [TerapiController::class, 'laporanTerapi'])->name('terapi.laporanTerapi');
        Route::get('/getData/{id}/detail', [TerapiController::class, 'showDetail'])->name('terapi.detail');
        Route::get('/laporanDetail/{id}', [TerapiController::class, 'laporanDetail'])->name('terapi.laporanDetail');

    });

    Route::prefix('dashboard')->group(function () {
        Route::get('/export-obat-order', [DashboardController::class, 'exportObatOrder']);
    });

    Route::prefix('users')->group(function () {
        Route::get('/index', [UserController::class, 'index'])->name('users.index');
        Route::get('/get-user', [UserController::class, 'getUser'])->name('users.get-user');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('edit/{id}', [UserController::class, 'edit'])->name('users.edit-user');
        Route::put('update/{id}', [UserController::class, 'update'])->name('users.update-user');
        Route::delete('hapus/{id}', [UserController::class, 'destroy'])->name('users.hapus-user');
    });

});
