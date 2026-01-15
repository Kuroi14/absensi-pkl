<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Absensi;
use Illuminate\Http\Request;


abstract class Controller
{
    public function exportPdf(Request $request)
{
    $bulan = $request->bulan ?? now()->format('Y-m');

    $start = \Carbon\Carbon::parse($bulan)->startOfMonth();
    $end   = \Carbon\Carbon::parse($bulan)->endOfMonth();

    $query = Absensi::with('siswa')
        ->whereBetween('tanggal', [$start, $end]);

    if (auth()->user()->role === 'guru') {
        $query->whereHas('siswa', function ($q) {
            $q->where('guru_id', auth()->user()->guru->id);
        });
    }

    $absensis = $query->get()->groupBy('siswa_id');

    $pdf = Pdf::loadView('rekap.pdf', compact('absensis','bulan'));

    return $pdf->download('rekap-absensi-'.$bulan.'.pdf');
}
}
