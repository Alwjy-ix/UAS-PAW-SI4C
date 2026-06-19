<?php

// Salin baris-baris di bawah ke routes/web.php milikmu.
// Kalau project sudah punya middleware auth (misalnya dari Breeze),
// bungkus route ini dengan Route::middleware('auth')->group(function () { ... }).

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServisController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/servis/tambah', [ServisController::class, 'create'])->name('servis.create');
Route::post('/servis', [ServisController::class, 'store'])->name('servis.store');
