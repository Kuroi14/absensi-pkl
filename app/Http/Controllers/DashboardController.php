<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.admin', [
            'totalAdmin' => User::where('role','admin')->count(),
            'totalGuru'  => User::where('role','guru')->count(),
            'totalSiswa'=> User::where('role','siswa')->count(),
        ]);
    }
}
