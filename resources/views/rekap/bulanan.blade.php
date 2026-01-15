@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-4">

    <h1 class="text-xl font-bold">Rekap Absensi Bulanan</h1>

    {{-- FILTER BULAN --}}
    <form method="GET" class="flex gap-2 items-center">
        <input type="month" name="bulan"
               value="{{ $bulan }}"
               class="border rounded px-3 py-2">
        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Tampilkan
        </button>
    </form>

    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="min-w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-3 py-2">No</th>
                    <th class="border px-3 py-2">Nama Siswa</th>
                    <th class="border px-3 py-2">Kelas</th>
                    <th class="border px-3 py-2">Hadir</th>
                    <th class="border px-3 py-2">Tidak Hadir</th>
                </tr>
            </thead>
            <tbody>
                @forelse($absensis as $items)
                    @php
                        $siswa = $items->first()->siswa;
                        $hadir = $items->count();
                        $totalHari = now()->daysInMonth;
                        $tidakHadir = $totalHari - $hadir;
                    @endphp
                    <tr>
                        <td class="border px-3 py-2 text-center">{{ $loop->iteration }}</td>
                        <td class="border px-3 py-2">{{ $siswa->nama }}</td>
                        <td class="border px-3 py-2">{{ $siswa->kelas }}</td>
                        <td class="border px-3 py-2 text-center text-green-600 font-semibold">
                            {{ $hadir }}
                        </td>
                        <td class="border px-3 py-2 text-center text-red-600 font-semibold">
                            {{ $tidakHadir }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-500">
                            Tidak ada data absensi
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
