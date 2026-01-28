<?php

namespace App\Http\Controllers;

use App\Models\IzinAbsensi;
use App\Models\Absensi;
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

        return view('izin.index', compact('izins'));
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

        return view('izin.index', compact('izins'));
    }

    // ============================
    // APPROVE
    // ============================
    public function approve(IzinAbsensi $izin)
{
    $izin->update([
        'status' => 'approved',
        'approved_by' => auth()->id(),
        'approved_at' => now(),
    ]);

    // Jika absensi sudah ada → update
    $absensi = Absensi::where('siswa_id', $izin->siswa_id)
        ->whereDate('tanggal', $izin->tanggal)
        ->first();

    if ($absensi) {
        $absensi->update([
            'status' => $izin->jenis, // sakit / izin
        ]);
    }

    return back()->with('success', 'Izin disetujui');
}

    // ============================
    // REJECT
    // ============================
    public function reject(IzinAbsensi $izin)
    {
        $izin->update([
        'status' => 'rejected',
        'approved_by' => auth()->id(),
        'approved_at' => now(),
    ]);

    return back()->with('success', 'Izin ditolak');
    }
    // ============================
// SISWA → FORM IZIN
// ============================
public function create()
{
    $izins = IzinAbsensi::where('siswa_id', auth()->user()->siswa->id)
        ->orderByDesc('tanggal')
        ->get();

    return view('siswa.izin', compact('izins'));
}

// ============================
// SISWA → SIMPAN IZIN
// ============================
public function store(Request $request)
{
    $request->validate([
        'tanggal' => 'required|date',
        'jenis' => 'required|in:sakit,izin',
        'keterangan' => 'nullable|string',
        'bukti' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
    ]);

    IzinAbsensi::create([
        'siswa_id' => auth()->user()->siswa->id,
        'tanggal' => $request->tanggal,
        'jenis' => $request->jenis,
        'keterangan' => $request->keterangan,
        'bukti' => $request->file('bukti')?->store('izin', 'public'),
        'status' => 'pending',
    ]);

    return back()->with('success', 'Izin berhasil diajukan');
}

public function riwayatSiswa()
{
    $izins = IzinAbsensi::where('siswa_id', auth()->user()->siswa->id)
        ->orderByDesc('tanggal')
        ->get();

    return view('siswa.izin-riwayat', compact('izins'));
}


}