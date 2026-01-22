@extends('layouts.app')

@section('content')
<div class="bg-white p-4 rounded shadow">

    <h2 class="text-lg font-semibold mb-4">
        Monitoring Absensi Siswa Bimbingan
    </h2>
<form method="GET" action="{{ route('guru.absensi.download') }}" class="mb-4">
    <input type="month" name="bulan"
           value="{{ request('bulan', now()->format('Y-m')) }}"
           class="border p-2 rounded">

    <button class="bg-green-600 text-white px-4 py-2 rounded">
        Download Excel
    </button>
</form>
    <table class="w-full text-sm border">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-2 py-2">Tanggal</th>
                <th class="border px-2 py-2">Nama Siswa</th>
                <th class="border px-2 py-2">Status</th>
                <th class="border px-2 py-2">Check In</th>
                <th class="border px-2 py-2">Check Out</th>
                <th class="border px-2 py-2">Lokasi</th>
                <th class="border px-2 py-2">Tempat PKL</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($absensis as $absen)
            <tr>
                <td class="border px-2 py-1">
                    {{ \Carbon\Carbon::parse($absen->tanggal)->format('d-m-Y') }}
                </td>

                <td class="border px-2 py-1">
                    {{ $absen->siswa->nama }}
                </td>

                <td class="border px-2 py-1">
                    @if($absen->status === 'izin')
                        <span class="text-yellow-600 font-semibold">Izin</span>
                    @elseif($absen->check_in)
                        <span class="text-green-600 font-semibold">Hadir</span>
                    @else
                        <span class="text-red-600 font-semibold">Alpha</span>
                    @endif
                </td>

                <td class="border px-2 py-1">
                    {{ $absen->check_in ?? '-' }}
                </td>

                <td class="border px-2 py-1">
                    {{ $absen->check_out ?? '-' }}
                </td>

                <td class="border px-2 py-1">
                    {{ $absen->latitude }},
                    {{ $absen->longitude }}
                </td>

                <td class="border px-2 py-1">
                    {{ $absen->siswa->tempatPkl->nama ?? '-' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-4 text-gray-500">
                    Tidak ada data absensi
                </td>
            </tr>
            <td>
            </tbody>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $absensis->links() }}
    </div>
</div>
@endsection
