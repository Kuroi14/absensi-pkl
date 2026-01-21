<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\TempatPkl;
use App\Models\IzinAbsensi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // ================= ADMIN =================
    public function admin()
    {
        $bulan = request('bulan', now()->format('Y-m'));
        $carbon = Carbon::parse($bulan);

        $totalGuru    = Guru::all()->count();
        $totalSiswa   = Siswa::all()->count();
        $totalAbsensi = Absensi::whereNotNull('check_in')->count();
        $totalIzin    = Absensi::where('status', 'izin')->count();

        $grafik = Absensi::selectRaw('DATE(tanggal) as tgl, COUNT(*) as total')
            ->whereNotNull('check_in')
            ->whereMonth('tanggal', $carbon->month)
            ->whereYear('tanggal', $carbon->year)
            ->groupBy('tgl')
            ->orderBy('tgl')
            ->get();

        $labels = $grafik->pluck('tgl')->map(
            fn ($d) => Carbon::parse($d)->format('d')
        );

        $values = $grafik->pluck('total');

        $rekapGuru = Guru::withCount([
            'siswas',
            'siswas as total_hadir' => fn ($q) =>
                $q->whereHas('absensis', fn ($a) =>
                    $a->whereNotNull('check_in')
                )
        ])->get();

        $rekapBengkel = TempatPkl::withCount([
            'siswas',
            'siswas as total_hadir' => fn ($q) =>
                $q->whereHas('absensis', fn ($a) =>
                    $a->whereNotNull('check_in')
                )
        ])->get();

        return view('dashboard.admin', compact(
            'totalGuru',
            'totalSiswa',
            'totalAbsensi',
            'totalIzin',
            'labels',
            'values',
            'bulan',
            'rekapGuru',
            'rekapBengkel'
        ));
    }

    // ================= GURU =================
    public function guru()
{
    $guru = auth()->user()->guru;

    if (!$guru) {
        abort(403, 'Data guru belum terdaftar');
    }

    $today = Carbon::today();

    $totalSiswa = Siswa::where('guru_id', $guru->id)->count();

    $totalAbsenHariIni = Absensi::whereHas('siswa', function ($q) use ($guru) {
            $q->where('guru_id', $guru->id);
        })
        ->whereDate('tanggal', $today)
        ->whereNotNull('check_in')
        ->count();

    $izinPending = IzinAbsensi::whereHas('siswa', function ($q) use ($guru) {
            $q->where('guru_id', $guru->id);
        })
        ->where('status', 'pending')
        ->count();

    $koreksiPending = Absensi::whereHas('siswa', function ($q) use ($guru) {
            $q->where('guru_id', $guru->id);
        })
        ->whereNull('check_in')
        ->count();

    // =====================
    // DAFTAR SISWA BIMBINGAN
    // =====================
    $siswaBimbingan = Siswa::where('guru_id', $guru->id)
        ->orderBy('nama')
        ->get();
    $rekapSiswa = Siswa::withCount([
        'absensis as total_hadir' => fn ($q) =>
            $q->whereNotNull('check_in'),
        'absensis as total_izin' => fn ($q) =>
            $q->where('status', 'izin'),
        'absensis as total_alpha' => fn ($q) =>
            $q->whereNull('check_in')->where('status', '!=', 'izin')
    ])->get();

    return view('guru.dashboard', compact(
        'totalSiswa',
        'totalAbsenHariIni',
        'izinPending',
        'koreksiPending',
        'siswaBimbingan'
    ));
}

    // ================= SISWA =================
    public function siswa()
    {
        return view('dashboard.siswa');
    }
}

