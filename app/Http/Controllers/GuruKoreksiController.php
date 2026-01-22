<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\IzinAbsensi;

class GuruKoreksiController extends Controller
{
    public function index()
    {
        $guruId = auth()->user()->guru->id;

        $absens = Absensi::whereHas('siswa', function ($q) use ($guruId) {
                $q->where('guru_id', $guruId);
            })
            ->where('status', '!=', 'hadir')
            ->get();

        $izins = IzinAbsensi::whereHas('siswa', function ($q) use ($guruId) {
                $q->where('guru_id', $guruId);
            })
            ->get();

        return view('guru.koreksi', compact('absens', 'izins'));
    }

    public function update(Request $request, Absensi $absen)
    {
        $absen->update([
            'status'     => 'hadir',
            'jam_masuk'  => $request->jam_masuk,
            'jam_pulang' => $request->jam_pulang,
        ]);

        return back()->with('success', 'Absen berhasil dikoreksi');
    }
}
