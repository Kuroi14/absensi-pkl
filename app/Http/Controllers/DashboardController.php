<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\TempatPkl;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function admin()
    {
        // ======================
        // BULAN (DEFAULT BULAN INI)
        // ======================
        $bulan = request('bulan', now()->format('Y-m'));
        $carbon = Carbon::parse($bulan);

        // ======================
        // CARD RINGKASAN
        // ======================
        $totalGuru    = Guru::count();
        $totalSiswa   = Siswa::count();
        $totalAbsensi = Absensi::whereNotNull('check_in')->count();
        $totalIzin    = Absensi::where('status', 'izin')->count();

        // ======================
        // DATA GRAFIK BULANAN
        // ======================
        $grafik = Absensi::selectRaw('DATE(tanggal) as tgl, COUNT(*) as total')
            ->whereNotNull('check_in')
            ->whereMonth('tanggal', $carbon->month)
            ->whereYear('tanggal', $carbon->year)
            ->groupBy('tgl')
            ->orderBy('tgl')
            ->get();

        $labels = $grafik->pluck('tgl')
            ->map(fn ($d) => Carbon::parse($d)->format('d'))
            ->toArray();

        $values = $grafik->pluck('total')->toArray();

        // ======================
        // REKAP GURU
        // ======================
        $rekapGuru = Guru::withCount([
            'siswas',
            'siswas as total_hadir' => function ($q) {
                $q->whereHas('absensis', fn ($a) =>
                    $a->whereNotNull('check_in')
                );
            }
        ])->get();

        // ======================
        // REKAP BENGKEL
        // ======================
        $rekapBengkel = TempatPkl::withCount([
            'siswas',
            'siswas as total_hadir' => function ($q) {
                $q->whereHas('absensis', fn ($a) =>
                    $a->whereNotNull('check_in')
                );
            }
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
    public function index()
{
    $user = auth()->user();

    // ================= GURU =================
    if ($user->role === 'guru') {
        $guru = $user->guru;

        if (!$guru) {
            abort(403, 'Data guru belum terdaftar');
        }

        $hadir = Absensi::whereHas('siswa', function ($q) use ($guru) {
                $q->where('guru_id', $guru->id);
            })
            ->whereNotNull('check_in')
            ->count();

        $alpha = Absensi::whereHas('siswa', function ($q) use ($guru) {
                $q->where('guru_id', $guru->id);
            })
            ->whereNull('check_in')
            ->count();

        return view('dashboard.guru', compact('hadir','alpha'));
    }

    abort(403);
}
public function grafikPerSiswa($siswa_id)
{
    $bulan = request('bulan', now()->format('Y-m'));
    $carbon = Carbon::parse($bulan);

    $data = Absensi::selectRaw('DATE(tanggal) as tgl, COUNT(*) as total')
        ->where('siswa_id', $siswa_id)
        ->whereNotNull('check_in')
        ->whereMonth('tanggal', $carbon->month)
        ->whereYear('tanggal', $carbon->year)
        ->groupBy('tgl')
        ->orderBy('tgl')
        ->get();

    $labels = $data->pluck('tgl')
        ->map(fn ($d) => Carbon::parse($d)->format('d'))
        ->toArray();

    $values = $data->pluck('total')->toArray();

    return view('dashboard.siswa', compact(
        'labels',
        'values',
        'bulan'
    ));
}

public function guru()
{
    $guruId = auth()->user()->guru->id;

    $absensis = Absensi::whereHas('siswa', function ($q) use ($guruId) {
        $q->where('guru_id', $guruId);
    })
    ->latest()
    ->get();

    return view('guru.dashboard', compact('absensis'));
}

}
