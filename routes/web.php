<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\GuruDashboardController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\TempatPklController;

Route::redirect('/', '/login');

Route::get('/login', [AuthController::class,'loginForm'])->name('login');
Route::post('/login', [AuthController::class,'login']);
Route::post('/logout', [AuthController::class,'logout']);

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class,'index']);

    Route::middleware('role:admin')->group(function () {
        Route::resource('/users', UserController::class);
    });
Route::middleware('auth')->get('/dashboard', [DashboardController::class,'index']);

Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/guru', [GuruController::class,'index']);
    Route::post('/guru', [GuruController::class,'store']);
    Route::delete('/guru/{guru}', [GuruController::class,'destroy']);
});

Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/siswa', [SiswaController::class,'index']);
    Route::post('/siswa', [SiswaController::class,'store']);
    Route::delete('/siswa/{siswa}', [SiswaController::class,'destroy']);
});

Route::middleware(['auth','role:siswa'])->group(function () {
    Route::get('/absensi', [AbsensiController::class, 'index']);
    Route::post('/absensi/check-in', [AbsensiController::class, 'checkIn']);
    Route::post('/absensi/check-out', [AbsensiController::class, 'checkOut']);
});

Route::middleware(['auth','role:guru'])->group(function () {
    Route::get('/absensi', [AbsensiController::class,'indexGuru']);
});

Route::middleware(['auth','role:guru'])->group(function () {
    Route::get('/guru/dashboard', [GuruDashboardController::class, 'index']);
});

Route::middleware(['auth','role:admin,guru'])->group(function () {
    Route::get('/rekap', [RekapController::class, 'index']);
});

Route::middleware(['auth','role:admin'])->group(function () {
    Route::resource('tempat-pkl', TempatPklController::class);
});


});