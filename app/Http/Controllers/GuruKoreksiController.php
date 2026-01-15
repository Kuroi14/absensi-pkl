<?php
use App\Models\Absensi;

class GuruKoreksiController extends Controller
{
    public function index()
    {
        $absens = Absensi::whereHas('siswa', function($q){
            $q->where('guru_id', auth()->user()->guru->id);
        })
        ->where('status','!=','hadir')
        ->get();

        return view('guru.koreksi', compact('absens'));
    }

    public function update(Request $r, Absensi $absen)
    {
        $absen->update([
            'status'=>'hadir',
            'jam_masuk'=>$r->jam_masuk,
            'jam_pulang'=>$r->jam_pulang
        ]);

        return back()->with('success','Absen dikoreksi');
    }
}
