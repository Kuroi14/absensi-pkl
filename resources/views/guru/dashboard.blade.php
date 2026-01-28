@extends('layouts.app')

@section('content')
@php
    $rekapSiswa = $rekapSiswa ?? collect();
    $rekapBimbingan = $rekapBimbingan ?? collect();
@endphp

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="bg-white p-5 rounded-lg shadow flex items-center gap-4">
        <span class="w-12 h-12 flex items-center justify-center
                     rounded-lg bg-blue-100 text-blue-600">
            <span class="material-symbols-outlined text-3xl">
                dashboard
            </span>
        </span>

        <div>
            <h2 class="text-xl font-bold text-gray-800">
                Dashboard Guru
            </h2>
            <p class="text-sm text-gray-500">
                Ringkasan monitoring absensi dan bimbingan PKL
            </p>
        </div>
    </div>

    {{-- =====================
        STATISTIK ATAS
    ===================== --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

        {{-- Siswa Bimbingan --}}
        <div class="bg-white p-4 rounded-xl shadow
                    flex items-center gap-4 border-l-4 border-blue-500">
            <span class="w-12 h-12 flex items-center justify-center
                         rounded-lg bg-blue-100 text-blue-600">
                <span class="material-symbols-outlined text-2xl">
                    groups
                </span>
            </span>
            <div>
                <p class="text-gray-500 text-sm">
                    Siswa Bimbingan
                </p>
                <h2 class="text-2xl font-bold text-blue-600">
                    {{ $totalSiswa }}
                </h2>
            </div>
        </div>

        {{-- Absen Hari Ini --}}
        <div class="bg-white p-4 rounded-xl shadow
                    flex items-center gap-4 border-l-4 border-green-500">
            <span class="w-12 h-12 flex items-center justify-center
                         rounded-lg bg-green-100 text-green-600">
                <span class="material-symbols-outlined text-2xl">
                    how_to_reg
                </span>
            </span>
            <div>
                <p class="text-gray-500 text-sm">
                    Absen Hari Ini
                </p>
                <h2 class="text-2xl font-bold text-green-600">
                    {{ $totalAbsenHariIni }}
                </h2>
            </div>
        </div>

        {{-- Izin Pending --}}
        <div class="bg-white p-4 rounded-xl shadow
                    flex items-center gap-4 border-l-4 border-orange-500">
            <span class="w-12 h-12 flex items-center justify-center
                         rounded-lg bg-orange-100 text-orange-600">
                <span class="material-symbols-outlined text-2xl">
                    mail
                </span>
            </span>
            <div>
                <p class="text-gray-500 text-sm">
                    Izin Pending
                </p>
                <h2 class="text-2xl font-bold text-orange-600">
                    {{ $izinPending }}
                </h2>
            </div>
        </div>

        {{-- Koreksi Pending --}}
        <div class="bg-white p-4 rounded-xl shadow
                    flex items-center gap-4 border-l-4 border-purple-500">
            <span class="w-12 h-12 flex items-center justify-center
                         rounded-lg bg-purple-100 text-purple-600">
                <span class="material-symbols-outlined text-2xl">
                    edit_note
                </span>
            </span>
            <div>
                <p class="text-gray-500 text-sm">
                    Koreksi Pending
                </p>
                <h2 class="text-2xl font-bold text-purple-600">
                    {{ $koreksiPending }}
                </h2>
            </div>
        </div>

    </div>

    {{-- =====================
        DAFTAR SISWA
    ===================== --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b">
            <h3 class="text-lg font-semibold text-gray-700">
                Daftar Siswa Bimbingan
            </h3>
        </div>

        @if($siswaBimbingan->isEmpty())
            <div class="p-6 text-center text-gray-500 text-sm">
                Belum ada siswa bimbingan.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="border px-4 py-3 text-left">
                                Nama Siswa
                            </th>
                            <th class="border px-4 py-3 text-center">
                                Hadir
                            </th>
                            <th class="border px-4 py-3 text-center">
                                Izin
                            </th>
                            <th class="border px-4 py-3 text-center">
                                Alpha
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                    @foreach($siswaBimbingan as $siswa)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="border px-4 py-2 font-medium">
                                {{ $siswa->nama }}
                            </td>
                            <td class="border px-4 py-2 text-center">
                                <span class="font-semibold text-green-600">
                                    {{ $siswa->total_hadir }}
                                </span>
                            </td>
                            <td class="border px-4 py-2 text-center">
                                <span class="font-semibold text-yellow-600">
                                    {{ $siswa->total_izin }}
                                </span>
                            </td>
                            <td class="border px-4 py-2 text-center">
                                <span class="font-semibold text-red-600">
                                    {{ $siswa->total_alpha }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>
@endsection
