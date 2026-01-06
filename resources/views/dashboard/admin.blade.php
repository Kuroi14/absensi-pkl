@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-6">Dashboard Admin</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <div class="bg-white rounded shadow p-6 border-l-4 border-blue-500">
        <p class="text-gray-500 text-sm">Total Admin</p>
        <p class="text-3xl font-bold text-blue-600">
            {{ $totalAdmin }}
        </p>
    </div>

    <div class="bg-white rounded shadow p-6 border-l-4 border-green-500">
        <p class="text-gray-500 text-sm">Total Guru</p>
        <p class="text-3xl font-bold text-green-600">
            {{ $totalGuru }}
        </p>
    </div>

    <div class="bg-white rounded shadow p-6 border-l-4 border-purple-500">
        <p class="text-gray-500 text-sm">Total Siswa</p>
        <p class="text-3xl font-bold text-purple-600">
            {{ $totalSiswa }}
        </p>
    </div>

</div>

@endsection
