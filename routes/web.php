<?php

use App\Http\Controllers\Dokter\JadwalPeriksaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\ObatController;
use App\Http\Controllers\Admin\AdminPoliController;
use App\Http\Controllers\Admin\DokterController;
use App\Http\Controllers\Admin\PasienController;

// Redirect halaman utama ke login
Route::redirect('/', '/login');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterPasien'])->name('register');
Route::post('/register', [AuthController::class, 'registerPasien'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Group Routes dengan Authentikasi
Route::middleware(['auth'])->group(function () {

   // 1. Admin
Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
    Route::resource('obat', ObatController::class);
});

   // 2. Dokter
Route::middleware(['role:dokter'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dokter'])->name('dashboard');
    Route::resource('jadwal-periksa', JadwalPeriksaController::class);
});

    // 3. Pasien
    Route::middleware(['role:pasien'])->prefix('pasien')->name('pasien.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'pasien'])->name('dashboard');
    });

});