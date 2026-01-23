<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Siswa;

class SiswaDashboardController extends Controller
{
    public function index()
    {
        $siswaId = auth()->user()->siswa->id;

        $hadir = Absensi::where('siswa_id', $siswaId)
            ->where('status', 'hadir')
            ->count();

        $izin = Absensi::where('siswa_id', $siswaId)
            ->where('status', 'izin')
            ->count();

        $alpha = Absensi::where('siswa_id', $siswaId)
            ->where('status', 'alpha')
            ->count();

        $pending = Absensi::where('siswa_id', $siswaId)
            ->where('status', 'pending')
            ->count();

        $disetujui = Absensi::where('siswa_id', $siswaId)
            ->where('status', 'disetujui')
            ->count();

        $ditolak = Absensi::where('siswa_id', $siswaId)
            ->where('status', 'ditolak')
            ->count();

        // biodata guru pembimbing & bengkel
        $siswa = Siswa::with(['guru', 'tempatPkl'])
            ->findOrFail($siswaId);

        return view('dashboard.siswa', compact(
            'hadir',
            'izin',
            'alpha',
            'pending',
            'disetujui',
            'ditolak',
            'siswa'
        ));
    }
}
