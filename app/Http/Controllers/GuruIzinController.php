<?php
use App\Models\Izin;

class GuruIzinController extends Controller
{
    public function index()
    {
        $izins = Izin::whereHas('siswa', function($q){
            $q->where('guru_id', auth()->user()->guru->id);
        })->orderBy('tanggal','desc')->get();

        return view('guru.izin', compact('izins'));
    }

    public function approve(Izin $izin)
    {
        $izin->update(['status'=>'disetujui']);

        Absensi::updateOrCreate(
            [
                'siswa_id'=>$izin->siswa_id,
                'tanggal'=>$izin->tanggal
            ],
            [
                'status'=>$izin->jenis,
                'keterangan'=>$izin->alasan
            ]
        );

        return back()->with('success','Izin disetujui');
    }

    public function reject(Izin $izin)
    {
        $izin->update(['status'=>'ditolak']);
        return back()->with('success','Izin ditolak');
    }
}
