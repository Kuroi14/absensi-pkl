<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        DB::transaction(function () use ($r) {

            $user = User::create([
                'nama' => $r->nama,
                'username' => $r->username,
                'password' => bcrypt($r->password),
                'role' => 'guru',
            ]);

            Guru::create([
                'user_id' => $user->id,
                'nip' => $r->nip,
                'nama' => $r->nama,
                'mapel' => $r->mapel,
                'no_hp' => $r->no_hp,
            ]);
        });

        return redirect()->back()->with('success','Guru berhasil ditambahkan');
    }

    public function destroy(Guru $guru)
    {
        $guru->user()->delete(); // cascade guru juga
        return back()->with('success','Guru dihapus');
    }
}
