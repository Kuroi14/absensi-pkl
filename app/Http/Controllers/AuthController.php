<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller {

     public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $r)
    {
        if (Auth::attempt([
            'username' => $r->username,
            'password' => $r->password
        ])) {
            $r->session()->regenerate();

            $role = auth()->user()->role;

            return match ($role) {
                'admin' => redirect()->route('admin.dashboard'),
                'guru'  => redirect()->route('guru.dashboard'),
                'siswa' => redirect()->route('siswa.dashboard'),
                default => abort(403),
            };
        }

        return back()->with('error','Login gagal');
    }

    public function logout(Request $r)
    {
        Auth::logout();
        $r->session()->invalidate();
        return redirect('/login');
    }
}
