<?php

namespace App\Http\Controllers;

use App\Models\IzinAbsensi;
use Illuminate\Http\Request;

class IzinAbsensiController extends Controller
{
    // ============================
    // ADMIN → semua siswa
    // ============================
    public function index()
    {
        $izins = IzinAbsensi::with('siswa')
            ->orderByDesc('tanggal')
            ->get();

        return view('admin.izin', compact('izins'));
    }

    // ============================
    // GURU → hanya siswa bimbingan
    // ============================
    public function indexGuru()
    {
        $guru = auth()->user()->guru;

        if (!$guru) {
            abort(403, 'Akun ini bukan guru');
        }

        $izins = IzinAbsensi::with('siswa')
            ->whereHas('siswa', function ($q) use ($guru) {
                $q->where('guru_id', $guru->id);
            })
            ->orderByDesc('tanggal')
            ->get();

        return view('guru.koreksi', compact('izins'));
    }

    // ============================
    // APPROVE
    // ============================
    public function approve(IzinAbsensi $izin)
    {
        $izin->update(['status' => 'disetujui']);
        return back()->with('success', 'Izin disetujui');
    }

    // ============================
    // REJECT
    // ============================
    public function reject(IzinAbsensi $izin)
    {
        $izin->update(['status' => 'ditolak']);
        return back()->with('success', 'Izin ditolak');
    }
}
