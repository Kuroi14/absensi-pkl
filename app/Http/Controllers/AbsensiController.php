<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\AbsensiLog;

class AbsensiController extends Controller
{
    public function index()
{
    $user = auth()->user();

    $siswa = $user->siswa;
    if (!$siswa) {
        abort(403, 'Data siswa belum terdaftar');
    }

    if (!$siswa->tempatPkl) {
        abort(403, 'Anda belum ditempatkan PKL');
    }

    $absen = Absensi::where('siswa_id', $siswa->id)
        ->whereDate('tanggal', now())
        ->first();

    return view('absensi.index', compact('absen','siswa'));
}


    // ===============================
    // ✅ CHECK IN
    // ===============================
    public function checkIn(Request $request)
{
    $request->validate([
        'lat' => 'required',
        'lng' => 'required',
        'foto' => 'required|image|max:2048',
    ]);

    $siswa = auth()->user()->siswa;
    $tempat = $siswa->tempatPkl;

    // Cegah double check-in
    if (Absensi::where('siswa_id', $siswa->id)
        ->whereDate('tanggal', now())
        ->exists()) {
        return back()->withErrors('Anda sudah check-in hari ini');
    }

    $jarak = $this->hitungJarak(
        $request->lat,
        $request->lng,
        $tempat->latitude,
        $tempat->longitude
    );

    if ($jarak > $tempat->radius) {
        AbsensiLog::create([
            'siswa_id' => $siswa->id,
            'tanggal' => now()->toDateString(),
            'jarak' => round($jarak),
            'keterangan' => 'Check-in di luar radius PKL'
        ]);

        return back()->withErrors(
            'Jarak Anda ±'.round($jarak).' meter dari lokasi PKL'
        );
    }

    $foto = $request->file('foto')->store('absensi', 'public');

    Absensi::create([
        'siswa_id' => $siswa->id,
        'tanggal' => now()->toDateString(),
        'check_in' => now(),
        'lat_in' => $request->lat,
        'lng_in' => $request->lng,
        'foto_in' => $foto,
    ]);

    return back()->with('success','Check-in berhasil');
}


    // ===============================
    // ✅ CHECK OUT
    // ===============================
   public function checkOut(Request $request)
{
    $request->validate([
        'lat' => 'required',
        'lng' => 'required',
        'foto' => 'required|image|max:2048'
    ]);

    $siswa = auth()->user()->siswa;
    $tempat = $siswa->tempatPkl;

    $absen = Absensi::where('siswa_id', $siswa->id)
        ->whereDate('tanggal', now())
        ->whereNotNull('check_in')
        ->firstOrFail();

    if ($absen->check_out) {
        return back()->withErrors('Anda sudah check-out hari ini');
    }

    $jarak = $this->hitungJarak(
        $request->lat,
        $request->lng,
        $tempat->latitude,
        $tempat->longitude
    );

    if ($jarak > $tempat->radius) {
        AbsensiLog::create([
            'siswa_id' => $siswa->id,
            'tanggal' => now()->toDateString(),
            'jarak' => round($jarak),
            'keterangan' => 'Check-out di luar radius PKL'
        ]);

        return back()->withErrors(
            'Jarak Anda ±'.round($jarak).' meter dari lokasi PKL'
        );
    }

    $foto = $request->file('foto')->store('absensi', 'public');

    $absen->update([
        'check_out' => now(),
        'lat_out' => $request->lat,
        'lng_out' => $request->lng,
        'foto_out' => $foto
    ]);

    return back()->with('success','Check-out berhasil');
}



      // ===============================
      // Control Jarak
      // ===============================
private function hitungJarak($lat1, $lon1, $lat2, $lon2)
{
    $earthRadius = 6371000; // meter

    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);

    $a = sin($dLat/2) * sin($dLat/2) +
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
         sin($dLon/2) * sin($dLon/2);

    $c = 2 * atan2(sqrt($a), sqrt(1-$a));

    return $earthRadius * $c;
}

}
