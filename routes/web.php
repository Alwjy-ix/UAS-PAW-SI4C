<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JadwalMekanikController;
use App\Http\Controllers\MekanikController;
use App\Http\Controllers\MotorController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ServisController;
use App\Http\Controllers\SparepartController;
use App\Http\Controllers\PkbController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Authentication Routes (Guest Only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
});

// Protected Application Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('/pelanggan', PelangganController::class);
    Route::resource('/motor', MotorController::class);
    Route::resource('/mekanik', MekanikController::class);
    Route::resource('/sparepart', SparepartController::class);
    Route::post('/sparepart/{sparepart}/stok', [SparepartController::class, 'updateStok'])->name('sparepart.updateStok');

    Route::resource('/jadwal', JadwalMekanikController::class)->except(['show']);
    Route::post('/jadwal/{jadwal}/status', [JadwalMekanikController::class, 'updateStatus'])->name('jadwal.updateStatus');

    Route::get('/servis', [ServisController::class, 'index'])->name('servis.index');
    Route::get('/servis/tambah', [ServisController::class, 'create'])->name('servis.create');
    Route::post('/servis', [ServisController::class, 'store'])->name('servis.store');
    Route::get('/servis/{servis}', [ServisController::class, 'show'])->name('servis.show');
    Route::post('/servis/{servis}/status', [ServisController::class, 'updateStatus'])->name('servis.updateStatus');

    Route::get('/pkb', [PkbController::class, 'index'])->name('pkb.index');
    Route::get('/pkb/{servis}', [PkbController::class, 'show'])->name('pkb.show');
    Route::put('/pkb/{servis}', [PkbController::class, 'update'])->name('pkb.update');
});
