<?php

use App\Models\Absensi;

class GuruLaporanController extends Controller
{
    public function index(Request $r)
    {
        $data = Absensi::whereHas('siswa', function($q){
            $q->where('guru_id', auth()->user()->guru->id);
        })
        ->when($r->bulan,function($q) use($r){
            $q->whereMonth('tanggal',$r->bulan);
        })
        ->get();

        return view('guru.laporan', compact('data'));
    }
}
