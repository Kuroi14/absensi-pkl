<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         return view('users.index',['users'=>User::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    abort_if(auth()->user()->role !== 'admin', 403);

    $request->validate([
        'nama'     => 'required',
        'username' => 'required|unique:users,username',
        'password' => 'required|min:6',
        'role'     => 'required|in:admin,guru,siswa',
    ]);
    $passwordAsli = $request->password;
    User::create([
        'nama'           => $request->nama,
        'username'       => $request->username,
        'password'       => Hash::make($passwordAsli), // HASH
        'password_plain' => $passwordAsli,             // ASLI
        'role'           => $request->role,
    ]);

    return back()->with('password_awal', $passwordAsli);
}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
