<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AbsensiGuruExport;

class GuruLaporanController extends Controller
{
    public function index(Request $request)
    {
        $guru = auth()->user()->guru;

        if (!$guru) {
            abort(403);
        }

        $bulan = $request->bulan ?? now()->format('Y-m');

        $absensis = Absensi::with('siswa')
            ->whereHas('siswa', function ($q) use ($guru) {
                $q->where('guru_id', $guru->id);
            })
            ->whereMonth('tanggal', substr($bulan, 5, 2))
            ->whereYear('tanggal', substr($bulan, 0, 4))
            ->orderBy('tanggal')
            ->get();

        return view('guru.laporan', compact('absensis', 'bulan'));
    }

    public function download(Request $request)
    {
        $guru = auth()->user()->guru;

        if (!$guru) {
            abort(403);
        }

        $bulan = $request->bulan ?? now()->format('Y-m');

        return Excel::download(
            new AbsensiGuruExport($guru->id, $bulan),
            'laporan_absensi_'.$bulan.'.xlsx'
        );
    }
}
