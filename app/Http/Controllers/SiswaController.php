<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use App\Models\Guru;
use App\Models\TempatPkl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SiswaController extends Controller
{
    public function index()
    {
        return view('siswa.index', [
            'siswas' => Siswa::with(['guru','user','tempatPkl'])->get(),
            'gurus'  => Guru::all(),
            'tempatPkls' => TempatPkl::all(),
        ]);

}

    public function store(Request $r)
{
    DB::transaction(function () use ($r) {

        $user = User::create([
            'nama' => $r->nama,
            'username' => $r->username,
            'password' => bcrypt($r->password),
            'role' => 'siswa',
        ]);

        Siswa::create([
            'user_id' => $user->id,
            'guru_id' => $r->guru_id,
            'tempat_pkl_id' => $r->tempat_pkl_id,
            'nis' => $r->nis,
            'nama' => $r->nama,
            'kelas' => $r->kelas,

            // === BIODATA BARU ===
            'tempat_lahir' => $r->tempat_lahir,
            'tanggal_lahir' => $r->tanggal_lahir,
            'jenis_kelamin' => $r->jenis_kelamin,
            'alamat' => $r->alamat,
            'no_telp_siswa' => $r->no_telp_siswa,
            'no_telp_ortu' => $r->no_telp_ortu,
        ]);
    });

    return back()->with('success','Siswa berhasil ditambahkan');
}


    public function destroy(Siswa $siswa)
    {
        $siswa->user()->delete();
        return back()->with('success','Siswa dihapus');
    }

    public function create()
    {
        $tempatPkls = TempatPkl::all();
        return view('siswa.create', compact('tempatPkls'));
    }

   public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,csv'
    ]);

    $rows = Excel::toArray([], $request->file('file'))[0];

    $berhasil = 0;
    $gagal = 0;

    DB::beginTransaction();
    try {
        foreach ($rows as $i => $row) {

            // Skip header
            if ($i === 0) continue;

            // Skip baris kosong
            if (!isset($row[0]) || trim($row[0]) === '') continue;

            // VALIDASI GURU & TEMPAT PKL (PAKAI ID)
            $guru = Guru::find($row[5]);
            $tempat = TempatPkl::find($row[6]);

            if (!$guru || !$tempat) {
                $gagal++;
                continue;
            }

            // CEK USERNAME DUPLIKAT
            if (User::where('username', trim($row[3]))->exists()) {
                $gagal++;
                continue;
            }

            // BUAT USER
            $user = User::create([
                'nama'     => $row[1],
                'username' => trim($row[3]),
                'password' => Hash::make($row[4]),
                'role'     => 'siswa',
            ]);

            // BUAT SISWA
            Siswa::create([
                'user_id'       => $user->id,
                'guru_id'       => $guru->id,
                'tempat_pkl_id' => $tempat->id,
                'nis'           => $row[0],
                'nama'          => $row[1],
                'kelas'         => $row[2],
                'no_telp_siswa' => $row[7] ?? null,
                'no_telp_ortu'  => $row[8] ?? null,
                'jenis_kelamin' => $row[9] ?? null,
                'tempat_lahir'  => $row[10] ?? null,
                'tanggal_lahir' => $row[11] ?? null,
                'alamat'        => $row[12] ?? null,
            ]);

            $berhasil++;
        }

        DB::commit();

        return back()->with('success',
            "Import selesai. Berhasil: $berhasil | Gagal: $gagal"
        );

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors($e->getMessage());
    }
}


public function template()
{
    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename=template_siswa.csv',
    ];

    $callback = function () {
        $file = fopen('php://output', 'w');

        fputcsv($file, [
            'NIS',
            'Nama',
            'Kelas',
            'Username',
            'Password',
            'Guru ID',
            'Tempat PKL ID',
            'No HP Siswa',
            'No HP Orang Tua',
            'Jenis Kelamin (L/P)',
            'Tempat Lahir',
            'Tanggal Lahir (YYYY-MM-DD)',
            'Alamat'
        ]);

        // Contoh baris
        fputcsv($file, [
            '12345',
            'Nama Contoh',
            'XII TKJ',
            'username',
            'password',
            3,
            2,
            '08xxxxxxxx',
            '08xxxxxxxx',
            'L',
            'Jombang',
            '2005-01-01',
            'Alamat'
        ]);

        fclose($file);
    };

    return new StreamedResponse($callback, 200, $headers);
}
}
