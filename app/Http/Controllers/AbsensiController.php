<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\AbsensiLog;
use App\Models\IzinAbsensi;

use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        $siswa = auth()->user()->siswa ?? abort(403);
        $tempat = $siswa->tempatPkl ?? abort(403);

        $absen = Absensi::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', now())
            ->first();

        $izin = IzinAbsensi::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', now())
            ->where('status', 'disetujui')
            ->first();

        if ($izin) {
            return view('absensi.izin-harian', compact('izin'));
        }

        return view('absensi.index', compact('absen', 'siswa'));
    }

    public function checkIn(Request $request)
    {
        if (!now()->between(
            Carbon::createFromTime(6,0),
            Carbon::createFromTime(12,0)
        )) {
            return back()->withErrors('Check-in pukul 06.00 – 12.00');
        }

        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'accuracy' => 'nullable|numeric',
            'foto' => 'required|image|max:2048'
        ]);

        $siswa = auth()->user()->siswa;
        $tempat = $siswa->tempatPkl;

        if (Absensi::where('siswa_id',$siswa->id)
            ->whereDate('tanggal',now())->exists()) {
            return back()->withErrors('Sudah check-in');
        }

        $jarak = $this->hitungJarak(
            $request->lat,
            $request->lng,
            $tempat->latitude,
            $tempat->longitude
        );

        AbsensiLog::create([
            'siswa_id' => $siswa->id,
            'tanggal' => now()->toDateString(),
            'jarak' => round($jarak),
            'keterangan' => 'Check-in | acc '.$request->accuracy
        ]);

        if ($jarak > ($tempat->radius + 25)) {
            return back()->withErrors('Di luar radius PKL');
        }

        $foto = $request->file('foto')->store('absensi','public');

        Absensi::create([
            'siswa_id' => $siswa->id,
            'tanggal' => now()->toDateString(),
            'check_in' => now(),
            'lat_in' => $request->lat,
            'lng_in' => $request->lng,
            'foto_in' => $foto,
            'status' => 'hadir'
        ]);

        return back()->with('success','Check-in berhasil');
    }

    public function checkOut(Request $request)
    {
        if (!now()->between(
            Carbon::createFromTime(15,0),
            Carbon::createFromTime(18,0)
        )) {
            return back()->withErrors('Check-out pukul 15.00 – 18.00');
        }

        $request->validate([
            'lat'=>'required|numeric',
            'lng'=>'required|numeric',
            'accuracy'=>'required|numeric',
            'foto'=>'required|image|max:2048'
        ]);

        if ($request->accuracy > 100) {
            return back()->withErrors('Akurasi GPS buruk');
        }

        $siswa = auth()->user()->siswa;
        $tempat = $siswa->tempatPkl;

        $absen = Absensi::where('siswa_id',$siswa->id)
            ->whereDate('tanggal',now())
            ->firstOrFail();

        if ($absen->check_out) {
            return back()->withErrors('Sudah check-out');
        }

        $jarak = $this->hitungJarak(
            $request->lat,
            $request->lng,
            $tempat->latitude,
            $tempat->longitude
        );

        AbsensiLog::create([
            'siswa_id'=>$siswa->id,
            'tanggal'=>now()->toDateString(),
            'jarak'=>round($jarak),
            'keterangan'=>'Check-out'
        ]);

        if ($jarak > ($tempat->radius + 25)) {
            return back()->withErrors('Di luar radius PKL');
        }

        $foto = $request->file('foto')->store('absensi','public');

        $absen->update([
            'check_out'=>now(),
            'lat_out'=>$request->lat,
            'lng_out'=>$request->lng,
            'foto_out'=>$foto
        ]);

        return back()->with('success','Check-out berhasil');
    }

    private function hitungJarak($lat1,$lon1,$lat2,$lon2)
    {
        $R = 6371000;
        $dLat = deg2rad($lat2-$lat1);
        $dLon = deg2rad($lon2-$lon1);

        $a = sin($dLat/2)**2 +
             cos(deg2rad($lat1))*cos(deg2rad($lat2))*
             sin($dLon/2)**2;

        return $R * (2 * atan2(sqrt($a), sqrt(1-$a)));
    }
      public function monitoringGuru()
{
    $guru = auth()->user()->guru ?? abort(403);

    $absensi = Absensi::with(['siswa', 'siswa.tempatPkl'])
        ->whereDate('tanggal', now())
        ->orderBy('check_in', 'asc')
        ->paginate(20);

    return view('guru.monitoring', compact('absensi'));
}
public function monitoringSiswa()
{
    $siswa = auth()->user()->siswa ?? abort(403);

    $absensi = Absensi::where('siswa_id', $siswa->id)
        ->orderBy('tanggal', 'desc')
        ->paginate(10);

    return view('siswa.monitoring', compact('absensi'));
}

}
