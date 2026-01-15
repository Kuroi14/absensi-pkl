<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class GuruController extends Controller
{
    public function index()
    {
        return view('guru.index', [
            'gurus' => Guru::with('user')->get()
        ]);
    }

   public function store(Request $r)
{
    $r->validate([
        'username' => 'required|unique:users,username',
        'password' => 'required',
        'nama' => 'required',
    ]);

    DB::transaction(function () use ($r) {

        $user = User::create([
            'nama'     => $r->nama,
            'username' => $r->username,
            'password' => bcrypt($r->password),
            'role'     => 'guru',
        ]);

        Guru::create([
            'user_id'          => $user->id,
            'nip'              => $r->nip,
            'nama'             => $r->nama,
            'mapel'            => $r->mapel,
            'no_hp'            => $r->no_hp,
            'jenis_ketenagaan' => $r->jenis_ketenagaan,
            'alamat'           => $r->alamat,
        ]);
    });

    return back()->with('success','Guru berhasil ditambahkan');
}

    public function destroy(Guru $guru)
{
    if ($guru->siswas()->count() > 0) {
        return back()->with('error',
            'Guru tidak bisa dihapus karena masih memiliki siswa bimbingan'
        );
    }

    DB::transaction(function () use ($guru) {
        $guru->delete();
        $guru->user()->delete();
    });

    return back()->with('success','Guru berhasil dihapus');
}

   public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,csv'
    ]);

    $rows = Excel::toArray([], $request->file('file'))[0];

    DB::transaction(function () use ($rows) {
        foreach ($rows as $i => $row) {
            if ($i === 0) continue; // skip header

            // Cegah duplicate username
            if (User::where('username', $row[2])->exists()) {
                continue;
            }

            $user = User::create([
                'nama'     => $row[0],
                'username' => $row[2],
                'password' => bcrypt($row[3]),
                'role'     => 'guru',
            ]);

            Guru::create([
                'user_id'          => $user->id,
                'nama'             => $row[0],
                'nip'              => $row[1],
                'mapel'            => $row[4] ?? null,
                'no_hp'            => $row[5] ?? null,
                'jenis_ketenagaan' => $row[6] ?? null,
                'alamat'           => $row[7] ?? null,
            ]);
            if (!isset($row[0], $row[1], $row[2], $row[3])) {
    continue;
}
        }
    });

    return back()->with('success', 'Data guru berhasil diimport');
}

public function edit(Guru $guru)
  {
        return response()->json($guru->load('user'));
    }
public function update(Request $request, Guru $guru)
{
    $request->validate([
        'nama' => 'required',
        'username' => 'required',
    ]);

    // 1. Update tabel GURU
    $guru->update([
        'nip' => $request->nip,
        'nama' => $request->nama,
        'mapel' => $request->mapel,
        'no_hp' => $request->no_hp,
        'jenis_ketenagaan' => $request->jenis_ketenagaan,
        'alamat' => $request->alamat,
    ]);

    // 2. Update tabel USERS (akun login)
    $user = $guru->user;

    // Cek apakah username diganti
    if ($request->username != $user->username) {
        $request->validate([
            'username' => 'unique:users,username'
        ]);
    }

    $user->username = $request->username;

    // Kalau password diisi → ganti
    if ($request->password) {
        $user->password = bcrypt($request->password);
    }

    $user->save();

    return redirect()->route('admin.guru.index')->with('success','Data guru berhasil diupdate');
}



}
