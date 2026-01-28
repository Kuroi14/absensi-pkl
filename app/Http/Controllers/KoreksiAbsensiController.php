<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\KoreksiAbsensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KoreksiAbsensiController extends Controller
{
    /**
     * ===============================
     * 1. LIST ABSENSI & KOREKSI
     * ===============================
     */
    public function index()
    {
        $absensis = Absensi::with([
            'siswa.user',
            'koreksi'
        ])
        ->orderBy('tanggal', 'desc')
        ->get();

        return view('koreksi-absensi.index', compact('absensis'));
    }

    public function indexGuru()
{
    $guru = auth()->user()->guru;

    if (!$guru) {
        abort(403, 'Akun ini bukan guru');
    }

    $absensis = Absensi::with([
        'siswa.user',
        'koreksi'
    ])
    ->whereHas('siswa', function ($q) use ($guru) {
        $q->where('guru_id', $guru->id);
    })
    ->orderBy('tanggal', 'desc')
    ->get();

    return view('koreksi-absensi.index', compact('absensis'));
}


    /**
     * ===============================
     * 2. AJUKAN KOREKSI ABSEN
     * ===============================
     */
    public function store(Request $request, Absensi $absensi)
    {
        $request->validate([
            'check_in_time'  => 'nullable|date_format:H:i',
            'check_out_time' => 'nullable|date_format:H:i',
            'alasan'         => 'required|string',
        ]);

        // Cegah koreksi ganda
        if ($absensi->koreksi) {
            return back()->with('error', 'Koreksi untuk absensi ini sudah diajukan.');
        }

        KoreksiAbsensi::create([
            'absensi_id'    => $absensi->id,
            'siswa_id'      => $absensi->siswa_id,
            'tanggal'       => $absensi->tanggal,

            'check_in_time' => $request->check_in_time,
            'check_out_time' => $request->check_out_time,

            'lat_in'        => $absensi->lat_in,
            'lng_in'        => $absensi->lng_in,
            'lat_out'       => $absensi->lat_out,
            'lng_out'       => $absensi->lng_out,

            'foto_in'       => $absensi->foto_in,
            'foto_out'      => $absensi->foto_out,

            'status'        => 'pending',
            'alasan'        => $request->alasan,
        ]);

        return back()->with('success', 'Pengajuan koreksi absensi berhasil dikirim.');
    }

    /**
     * ===============================
     * 3. SETUJUI KOREKSI
     * ===============================
     */
    public function approve(KoreksiAbsensi $koreksi)
    {
        // Update status koreksi
        $koreksi->update([
            'status'      => 'disetujui',
            'approved_by' => Auth::id(),
            'approved_at' => Carbon::now(),
        ]);

        // Terapkan perubahan ke absensi utama
        $absensi = $koreksi->absensi;

        $absensi->update([
            'check_in_time'  => $koreksi->check_in_time ?? $absensi->check_in_time,
            'check_out_time' => $koreksi->check_out_time ?? $absensi->check_out_time,
            'status'         => 'hadir',
        ]);

        return back()->with('success', 'Koreksi absensi berhasil disetujui.');
    }

    /**
     * ===============================
     * 4. TOLAK KOREKSI
     * ===============================
     */
    public function reject(KoreksiAbsensi $koreksi)
    {
        $koreksi->update([
            'status'      => 'ditolak',
            'approved_by' => Auth::id(),
            'approved_at' => Carbon::now(),
        ]);

        return back()->with('success', 'Koreksi absensi ditolak.');
    }
   
public function create(Absensi $absensi)
{
    // Pastikan absensi milik siswa yang login
    if ($absensi->siswa_id !== auth()->user()->siswa->id) {
        abort(403);
    }

    // Cegah koreksi ganda
    if ($absensi->koreksi) {
        return back()->with('error', 'Koreksi sudah diajukan.');
    }

    return view('siswa.koreksi-absensi.create', compact('absensi'));
}
 public function indexSiswa()
    {
        $siswa = Auth::user()->siswa;

        $koreksis = KoreksiAbsensi::with('absensi')
            ->where('siswa_id', $siswa->id)
            ->latest()
            ->get();

        return view('siswa.koreksi-absensi.index', compact('koreksis'));
    }
}
