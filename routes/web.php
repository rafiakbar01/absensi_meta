<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AttendanceController;

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

// Route untuk absensi
Route::get('/create', [AbsensiController::class, 'create'])->name('create');
Route::post('/store', [AbsensiController::class, 'store'])->name('store');

// Home route pointing to create
Route::get('/', [AbsensiController::class, 'create']);
Route::post('/', [AbsensiController::class, 'store'])->name('store');

// Route yang memerlukan autentikasi admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('index');
    Route::get('/export-attendance', [AttendanceController::class, 'export'])->name('export.attendance');
});

// Changed dashboard route to home
Route::get('/home', [AttendanceController::class, 'index'])->name('home');
Route::resource('attendance', AttendanceController::class);
Route::post('/send-email', [AbsensiController::class, 'sendEmail'])->name('send.email');
