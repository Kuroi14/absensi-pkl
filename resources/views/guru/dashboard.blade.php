@extends('layouts.app')

@section('content')
@php
    $rekapSiswa = $rekapSiswa ?? collect();
    $rekapBimbingan = $rekapBimbingan ?? collect();
@endphp
<h2 class="text-xl font-bold mb-4">Dashboard Guru</h2>
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">

<div class="bg-white p-4 rounded shadow border-l-4 border-blue-500">
    <p class="text-gray-500 text-sm">Siswa Bimbingan</p>
    <h2 class="text-2xl font-bold text-blue-600">{{ $totalSiswa }}</h2>
</div>

<div class="bg-white p-4 rounded shadow border-l-4 border-green-500">
    <p class="text-gray-500 text-sm">Absen Hari Ini</p>
    <h2 class="text-2xl font-bold text-green-600">{{ $totalAbsenHariIni }}</h2>
</div>

<div class="bg-white p-4 rounded shadow border-l-4 border-orange-500">
    <p class="text-gray-500 text-sm">Izin Pending</p>
    <h2 class="text-2xl font-bold text-orange-600">{{ $izinPending }}</h2>
</div>

<div class="bg-white p-4 rounded shadow border-l-4 border-purple-500">
    <p class="text-gray-500 text-sm">Koreksi Pending</p>
    <h2 class="text-2xl font-bold text-purple-600">{{ $koreksiPending }}</h2>
</div>
</div>

<div class="bg-white rounded shadow p-4 mt-6">
    <h3 class="text-lg font-semibold mb-4">Daftar Siswa Bimbingan</h3>

    @if($siswaBimbingan->isEmpty())
        <p class="text-gray-500 text-sm">Belum ada siswa bimbingan.</p>
    @else

            <div class="overflow-x-auto">
            <table class="w-full text-sm border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-3 py-2 text-left">Nama Siswa</th>
                        <th class="border px-3 py-2 text-left">Hadir</th>
                    <th class="border px-3 py-2 text-left">Izin</th>
                    <th class="border px-3 py-2 text-left">Alpha</th>
                </tr>
            </thead>
            <tbody>
                @foreach($siswaBimbingan as $index => $siswa)
                    <tr>
                        <td class="border px-3 py-2">{{ $siswa->nama }}</td>
                        <td class="border px-3 py-2">{{ $siswa->total_hadir }}</td>
                        <td class="border px-3 py-2">{{ $siswa->total_izin }}</td>
                        <td class="border px-3 py-2">{{ $siswa->total_alpha }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    @endif
@endsection
