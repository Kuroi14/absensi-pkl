<?php

namespace App\Http\Controllers;

use App\Models\IzinAbsensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IzinAbsensiController extends Controller
{
    public function indexGuru()
{
    $guruId = auth()->id();

    $izins = \App\Models\IzinAbsensi::whereHas('siswa', function ($q) use ($guruId) {
            $q->where('guru_id', $guruId);
        })
        ->orderBy('created_at', 'desc')
        ->get();

    return view('guru.izin', compact('izins'));
}


    public function reject($id)
    {
        $izin = IzinAbsensi::findOrFail($id);

        $izin->update([
            'status'      => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now()
        ]);

        return back()->with('success', 'Izin ditolak');
    }
}
