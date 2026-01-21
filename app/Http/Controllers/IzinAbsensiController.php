<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IzinAbsensi;
use App\Models\izin;

class IzinAbsensiController extends Controller
{
    public function index()
{
    $izins = Izin::with('siswa')->latest()->get();

    return view('izin.index', compact('izins'));
}
    // ================= SISWA =================
    public function create()
    {
        return view('siswa.izin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required',
            'keterangan' => 'nullable',
            'bukti' => 'nullable|image|max:2048'
        ]);

        $bukti = null;
        if ($request->hasFile('bukti')) {
            $bukti = $request->file('bukti')->store('izin','public');
        }

        IzinAbsensi::create([
            'siswa_id' => auth()->user()->siswa->id,
            'tanggal' => $request->tanggal,
            'jenis' => $request->jenis,
            'keterangan' => $request->keterangan,
            'bukti' => $bukti,
        ]);

        return back()->with('success','Pengajuan izin berhasil dikirim');
    }

    // ================= GURU =================
    public function indexGuru()
    {
        $izins = IzinAbsensi::with('siswa')->where('status','pending')->get();
        return view('guru.izin.index', compact('izins'));
    }

    public function approve($id)
    {
        IzinAbsensi::findOrFail($id)->update([
            'status' => 'approved',
            'approved_by' => auth()->user()->guru->id,
            'approved_at' => now()
        ]);

        return back();
    }

    public function reject($id)
    {
        IzinAbsensi::findOrFail($id)->update([
            'status' => 'rejected',
            'approved_by' => auth()->user()->guru->id,
            'approved_at' => now()
        ]);

        return back();
    }
    

}

