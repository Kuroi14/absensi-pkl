<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\RekapBulananExport;
use Maatwebsite\Excel\Facades\Excel;

class RekapController extends Controller
{
    public function index(Request $r)
    {
        $bulan = $r->bulan ?? date('m');
        $tahun = $r->tahun ?? date('Y');

        $query = Absensi::select(
                'siswas.nis',
                'siswas.nama',
                'siswas.kelas',
                'tempat_pkls.nama as tempat_pkl',
                DB::raw('COUNT(absensis.id) as hadir')
            )
            ->join('siswas', 'absensis.siswa_id', '=', 'siswas.id')
            ->join('tempat_pkls', 'siswas.tempat_pkl_id', '=', 'tempat_pkls.id')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->groupBy(
                'siswas.nis',
                'siswas.nama',
                'siswas.kelas',
                'tempat_pkls.nama'
            );

        // Jika guru login → hanya siswa bimbingannya
        if (auth()->user()->role === 'guru') {
            $guruId = auth()->user()->guru->id;
            $query->where('siswas.guru_id', $guruId);
        }

        $rekap = $query->get();

        return view('rekap.index', compact('rekap','bulan','tahun'));
    }
    public function bulanan(Request $request)
{
    $bulan = $request->bulan ?? now()->format('Y-m');

    $start = Carbon::createFromFormat('Y-m', $bulan)->startOfMonth();
    $end   = Carbon::createFromFormat('Y-m', $bulan)->endOfMonth();

    $query = Absensi::with('siswa')
        ->whereBetween('tanggal', [$start, $end]);

    if (auth()->user()->role === 'guru') {
        $query->whereHas('siswa', function ($q) {
            $q->where('guru_id', auth()->user()->guru->id);
        });
    }

    $absensis = $query->get()->groupBy('siswa_id');

    return view('rekap.bulanan', compact('absensis','bulan'));
}

    public function exportExcel(Request $request)
{
    $bulan = $request->bulan ?? now()->format('Y-m');

    return Excel::download(
        new RekapBulananExport($bulan),
        'rekap-absensi-'.$bulan.'.xlsx'
    );
}

private function resolveBulan(Request $request)
{
    $bulan = $request->bulan;

    // Jika kosong atau tidak sesuai format Y-m
    if (!$bulan || !preg_match('/^\d{4}-\d{2}$/', $bulan)) {
        return now()->format('Y-m');
    }

    return $bulan;
}

}

