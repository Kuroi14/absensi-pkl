<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
}
