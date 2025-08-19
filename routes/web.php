<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AttendanceController;

Auth::routes();

// Ubah route utama agar mengarah ke halaman absensi
Route::get('/', [AbsensiController::class, 'create'])->name('home');
Route::post('/', [AbsensiController::class, 'store'])->name('store');

// Route untuk absensi
Route::get('/create', [AbsensiController::class, 'create'])->name('create');
Route::post('/store', [AbsensiController::class, 'store'])->name('store');

// Route yang memerlukan autentikasi admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('index');
});

// Dashboard route
Route::get('/home', [AttendanceController::class, 'index'])->name('home');
Route::resource('attendance', AttendanceController::class);
Route::post('/send-email', [AbsensiController::class, 'sendEmail'])->name('send.email');

// Export route outside middleware
Route::get('/export-attendance', [AttendanceController::class, 'export'])->name('export.attendance');
Route::get('/export-attendance-excel', [AttendanceController::class, 'exportExcel'])->name('export.attendance.excel');
