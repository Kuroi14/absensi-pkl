<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\IzinAbsensi;
use App\Models\KoreksiAbsensi;

class GuruDashboardController extends Controller
{
    public function index()
    {
        $guru = auth()->user()->guru;

        if (!$guru) {
            abort(403, 'Akun ini belum terdaftar sebagai guru');
        }

        $today = now()->toDateString();

        // 1️⃣ TOTAL SISWA BIMBINGAN
        $totalSiswa = Siswa::where('guru_id', $guru->id)->count();

        // 2️⃣ ABSEN HARI INI
        $absenHariIni = Absensi::whereHas('siswa', function ($q) use ($guru) {
            $q->where('guru_id', $guru->id);
        })
        ->where('tanggal', $today)
        ->count();

        // 3️⃣ IZIN PENDING
        $izinPending = IzinAbsensi::whereHas('siswa', function ($q) use ($guru) {
            $q->where('guru_id', $guru->id);
        })
        ->where('status', 'pending')
        ->count();

        // 4️⃣ KOREKSI PENDING
        $koreksiPending = KoreksiAbsensi::whereHas('absensi.siswa', function ($q) use ($guru) {
            $q->where('guru_id', $guru->id);
        })
        ->where('status', 'pending')
        ->count();

        return view('guru.dashboard', compact(
            'totalSiswa',
            'absenHariIni',
            'izinPending',
            'koreksiPending'
        ));
    }
}
