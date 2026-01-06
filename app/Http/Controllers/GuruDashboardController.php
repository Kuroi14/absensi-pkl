<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;

class GuruDashboardController extends Controller
{
    public function index()
    {
        $guru = auth()->user()->guru;

        if (!$guru) {
            abort(403, 'Akun ini belum terdaftar sebagai guru');
        }

        $today = date('Y-m-d');

        $absensis = Absensi::with(['siswa'])
            ->whereHas('siswa', function ($q) use ($guru) {
                $q->where('guru_id', $guru->id);
            })
            ->where('tanggal', $today)
            ->get();

        return view('guru.dashboard', compact('absensis'));
    }
}
