<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\Siswa;

class AbsensiController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // 1️⃣ Validasi siswa
        $siswa = $user->siswa;
        if (!$siswa) {
            abort(403, 'Data siswa belum terdaftar');
        }

        // 2️⃣ Validasi tempat PKL
        if (!$siswa->tempatPkl) {
            abort(403, 'Anda belum ditempatkan PKL');
        }

        // 3️⃣ Cek absensi hari ini
        $absen = Absensi::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', now())
            ->first();

        return view('absensi.index', compact('absen'));
    }
}
