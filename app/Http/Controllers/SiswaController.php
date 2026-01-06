<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use App\Models\Guru;
use App\Models\TempatPkl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
}