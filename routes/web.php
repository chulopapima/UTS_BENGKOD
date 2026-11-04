<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// Admin Controllers
use App\Http\Controllers\Admin\ObatController;
use App\Http\Controllers\Admin\AdminPoliController;
use App\Http\Controllers\Admin\DokterController;
use App\Http\Controllers\Admin\PasienController;

// Dokter Controllers (Pastikan controller ini sudah ada)
use App\Http\Controllers\Dokter\JadwalPeriksaController;
use App\Http\Controllers\Dokter\PeriksaPasienController;
use App\Http\Controllers\Dokter\RiwayatPasienController;

// Pasien Controllers (Pastikan path dan nama controller-nya benar)
use App\Http\Controllers\Pasien\PoliController; 

// Redirect halaman utama ke login
Route::redirect('/', '/login');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterPasien'])->name('register');
Route::post('/register', [AuthController::class, 'registerPasien'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Group Routes dengan Authentikasi Utama
Route::middleware(['auth'])->group(function () {

    // 1. Admin
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        Route::resource('obat', ObatController::class);
        Route::resource('polis', AdminPoliController::class);
        Route::resource('dokter', DokterController::class);
        Route::resource('pasien', PasienController::class);
    });

    // 2. Dokter
    Route::middleware(['role:dokter'])->prefix('dokter')->name('dokter.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'dokter'])->name('dashboard');
        
        // Resource route otomatis menghasilkan: dokter.jadwal-periksa.index, dokter.jadwal-periksa.edit, dll.
        Route::resource('jadwal-periksa', JadwalPeriksaController::class);

        // Periksa Pasien
        Route::get('/periksa-pasien', [PeriksaPasienController::class, 'index'])->name('periksa-pasien.index');
        Route::post('/periksa-pasien', [PeriksaPasienController::class, 'store'])->name('periksa-pasien.store');
        Route::get('/periksa-pasien/{id}', [PeriksaPasienController::class, 'create'])->name('periksa-pasien.create');

        // Riwayat Pasien
        Route::get('/riwayat-pasien', [RiwayatPasienController::class, 'index'])->name('riwayat-pasien.index');
        Route::get('/riwayat-pasien/{id}', [RiwayatPasienController::class, 'show'])->name('riwayat-pasien.show');
    });

    // 3. Pasien
    Route::middleware(['role:pasien'])->prefix('pasien')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'pasien'])->name('pasien.dashboard');

        // Pendaftaran Poli
        Route::get('/daftar', [PoliController::class, 'get'])->name('pasien.daftar');
        Route::post('/daftar', [PoliController::class, 'submit'])->name('pasien.daftar.submit');
    });

});