<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\TempatPklController;
use App\Http\Controllers\GuruLaporanController;
use App\Exports\GuruTemplateExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\KoreksiAbsensiController;
use App\Http\Controllers\IzinAbsensiController;
use App\Http\Controllers\IzinSiswaController;
use App\Http\Controllers\GuruKoreksiController;
use App\Http\Controllers\SiswaDashboardController;

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
        Route::get('koreksi-absensi', [KoreksiAbsensiController::class, 'index'])->name('koreksi-absensi.index');
        Route::post('koreksi-absensi/{absensi}', [KoreksiAbsensiController::class, 'store'])->name('koreksi-absensi.store');
        Route::put('koreksi-absensi/{koreksi}/approve', [KoreksiAbsensiController::class, 'approve'])->name('koreksi-absensi.approve');
        Route::put('koreksi-absensi/{koreksi}/reject', [KoreksiAbsensiController::class, 'reject'])->name('koreksi-absensi.reject');
        
        Route::get('izin', [IzinAbsensiController::class,'index'])->name('izin.index');
        Route::post('izin/{i}/approve', [IzinAbsensiController::class,'approve'])->name('izin.approve');
        Route::post('izin/{id}/reject', [IzinAbsensiController::class,'reject'])->name('izin.reject');
        
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

    // IZIN SISWA BIMBINGAN
    Route::get('/izin', [IzinAbsensiController::class,'indexGuru'])
        ->name('guru.izin');

    Route::post('/izin/{izin}/approve', [IzinAbsensiController::class,'approve'])
        ->name('guru.izin.approve');

    Route::post('/izin/{izin}/reject', [IzinAbsensiController::class,'reject'])
        ->name('guru.izin.reject');

    // MONITORING ABSENSI
    Route::get('/monitoring', [AbsensiController::class,'monitoringGuru'])
        ->name('guru.monitoring');

    Route::get('/monitoring/download', [AbsensiController::class, 'downloadGuru'])
        ->name('guru.absensi.download');

    // LAPORAN GURU
    Route::get('/laporan', [GuruLaporanController::class,'index'])
        ->name('guru.laporan');

    Route::get('/laporan/download', [GuruLaporanController::class,'download'])
        ->name('guru.laporan.download');

    // KOREKSI ABSEN MANUAL
    Route::get('/koreksi', [GuruKoreksiController::class,'index'])
        ->name('guru.koreksi');

    Route::post('/koreksi/{absen}', [GuruKoreksiController::class,'update'])
        ->name('guru.koreksi.update');

    // KOREKSI ABSENSI (AJUAN SISWA)
    Route::get('/koreksi-absensi', [KoreksiAbsensiController::class, 'indexGuru'])
        ->name('guru.koreksi-absensi');

    Route::post('/koreksi-absensi/{koreksi}/approve', [KoreksiAbsensiController::class, 'approve'])
        ->name('guru.koreksi-absensi.approve');

    Route::post('/koreksi-absensi/{koreksi}/reject', [KoreksiAbsensiController::class, 'reject'])
        ->name('guru.koreksi-absensi.reject');

    Route::get('/absensi/check_in', [AbsensiController::class,'checkInForm'])
        ->name('guru.absensi.check-in.form');
});



    // ================= SISWA =================
    Route::prefix('siswa')
    ->middleware(['auth','role:siswa'])
    ->group(function () {

    // DASHBOARD
    Route::get('/dashboard', [SiswaDashboardController::class,'index'])
        ->name('siswa.dashboard');
    Route::get('/monitoring', [AbsensiController::class,'monitoringSiswa'])
        ->name('siswa.monitoring');

    // ABSENSI
    Route::get('/absensi', [AbsensiController::class,'index'])
        ->name('siswa.absensi');
    Route::post('/absensi/check-in', [AbsensiController::class,'checkIn'])
        ->name('siswa.absensi.check-in');
    Route::post('/absensi/check-out', [AbsensiController::class,'checkOut'])
        ->name('siswa.absensi.check-out');

    // KOREKSI ABSENSI
    Route::get('/koreksi-absensi', [KoreksiAbsensiController::class,'indexSiswa'])
        ->name('siswa.koreksi-absensi.index');
    Route::get('/koreksi-absensi/{absensi}', [KoreksiAbsensiController::class,'create'])
        ->name('siswa.koreksi-absensi.create');
    Route::post('/koreksi-absensi/{absensi}', [KoreksiAbsensiController::class,'store'])
        ->name('siswa.koreksi-absensi.store');

    // IZIN (MODAL)
    Route::get('/izin', [IzinAbsensiController::class,'create'])    
        ->name('siswa.izin');
    Route::post('/izin', [IzinAbsensiController::class,'store'])
        ->name('izin.store');
    Route::get('/izin/riwayat', [IzinAbsensiController::class,'riwayatSiswa'])
        ->name('siswa.izin.riwayat');
});

});