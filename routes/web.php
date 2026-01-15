<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\TempatPklController;
use App\Http\Controllers\GuruDashboardController;
use App\Exports\GuruTemplateExport;
use Maatwebsite\Excel\Facades\Excel;

Route::redirect('/', '/login');

// AUTH
Route::get('/login', [AuthController::class,'loginForm'])->name('login');
Route::post('/login', [AuthController::class,'login']);
Route::post('/logout', [AuthController::class,'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    // ================= ADMIN =================
    Route::prefix('admin')
        ->middleware('role:admin')
        ->as('admin.')
        ->group(function () {

        Route::get('/dashboard', [DashboardController::class,'admin'])
            ->name('dashboard');

        // MASTER
        Route::resource('guru', GuruController::class)->except(['show']);
        Route::post('guru/import', [GuruController::class,'import'])->name('guru.import');
        Route::resource('siswa', SiswaController::class)->except(['show']);
        Route::post('siswa/import', [SiswaController::class,'import'])->name('siswa.import');
         Route::get('siswa/template', [SiswaController::class, 'template'])->name('siswa.template');
        Route::resource('tempat-pkl', TempatPklController::class)->except(['show']);
        Route::post('tempat-pkl/import', [TempatPklController::class,'import'])->name('tempat-pkl.import');
        Route::resource('users', UserController::class)->except(['show']);

        Route::get('rekap', [RekapController::class,'index'])->name('rekap');
        Route::get('guru/template/download', function () {return Excel::download(new GuruTemplateExport,'template_upload_guru.xlsx');})->name('guru.template');
    });
Route::prefix('admin/tempat-pkl')->name('admin.tempat-pkl.')->group(function () {
    Route::post('/import', [TempatPklController::class, 'import'])->name('import');
    Route::get('/template', [TempatPklController::class, 'template'])->name('template');

   

});
    // ================= GURU =================
   Route::prefix('guru')->middleware(['auth','role:guru'])->group(function(){

    Route::get('/dashboard', [DashboardController::class,'guru'])
        ->name('guru.dashboard');

    Route::get('/absensi', [AbsensiController::class,'indexGuru'])
        ->name('guru.absensi');

    Route::get('/izin', [GuruController::class,'izin'])->name('guru.izin');
    Route::post('/izin/{id}/approve', [GuruController::class,'approveIzin']);
    Route::post('/izin/{id}/reject', [GuruController::class,'rejectIzin']);

    Route::get('/koreksi', [GuruController::class,'koreksi'])->name('guru.koreksi');
    Route::put('/koreksi/{id}', [GuruController::class,'updateKoreksi']);

    Route::get('/laporan', [GuruController::class,'laporan'])->name('guru.laporan');
});

    // ================= SISWA =================
    Route::prefix('siswa')
        ->middleware('role:siswa')
        ->group(function () {

        Route::get('/dashboard', [DashboardController::class,'siswa'])
            ->name('siswa.dashboard');

        Route::get('/absensi', [AbsensiController::class,'index']);
    });
});
