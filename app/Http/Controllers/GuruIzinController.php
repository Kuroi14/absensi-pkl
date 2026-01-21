<?php

namespace App\Http\Controllers;

use App\Models\IzinAbsensi;
use App\Models\Absensi;
use Illuminate\Http\Request;

class GuruIzinController extends Controller
{
    public function index()
    {
        $izins = IzinAbsensi::whereHas('siswa', function($q){
            $q->where('guru_id', auth()->user()->guru->id);
        })->orderBy('tanggal','desc')->get();

        return view('guru.izin', compact('izins'));
    }

    public function approve(IzinAbsensi $izin)
    {
        $izin->update(['status'=>'approved']);

        Absensi::updateOrCreate(
            [
                'siswa_id' => $izin->siswa_id,
                'tanggal'  => $izin->tanggal
            ],
            [
                'status'     => $izin->jenis,
                'keterangan' => $izin->alasan
            ]
        );

        return back()->with('success','Izin disetujui');
    }

    public function reject(IzinAbsensi $izin)
    {
        $izin->update(['status'=>'rejected']);
        return back()->with('success','Izin ditolak');
    }
}
