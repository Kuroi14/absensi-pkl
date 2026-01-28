@extends('layouts.app')

@section('content')
<div class="space-y-4">

    {{-- HEADER --}}
    <div class="bg-white p-5 rounded shadow flex items-center gap-3">
        <span class="w-12 h-12 flex items-center justify-center rounded-lg bg-blue-100 text-blue-600">
            <span class="material-symbols-outlined text-3xl">
                monitoring
            </span>
        </span>

        <div>
            <h2 class="text-xl font-bold">Monitoring Absensi</h2>
            <p class="text-sm text-gray-500">Data kehadiran siswa</p>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full text-sm border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-3 py-2 text-left">Tanggal</th>
                    <th class="border px-3 py-2 text-left">Check In</th>
                    <th class="border px-3 py-2 text-left">Check Out</th>
                    <th class="border px-3 py-2 text-left">Status</th>
                    <th class="border px-3 py-2 text-left">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($absensi as $absen)
<tr class="hover:bg-gray-50">
    <td class="border px-3 py-2">
        {{ \Carbon\Carbon::parse($absen->tanggal)->format('d-m-Y') }}
    </td>

    <td class="border px-3 py-2">
        {{ $absen->check_in ?? '-' }}
    </td>

    <td class="border px-3 py-2">
        {{ $absen->check_out ?? '-' }}
    </td>

    <td class="border px-3 py-2 font-semibold">
        @if($absen->check_in)
            <span class="text-green-600">Hadir</span>
        @else
            <span class="text-red-600">Belum Absen</span>
        @endif
    </td>

    {{-- ✅ AKSI --}}
    <td class="border px-3 py-2">
        <a href="{{ route('siswa.koreksi-absensi.create', $absen->id) }}"
           class="bg-yellow-500 text-white px-3 py-1 rounded text-xs hover:bg-yellow-600">
            Ajukan Koreksi
        </a>
    </td>
</tr>
@empty

                <tr>
                    <td colspan="4" class="text-center py-6 text-gray-500">
                        Belum ada data absensi
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
