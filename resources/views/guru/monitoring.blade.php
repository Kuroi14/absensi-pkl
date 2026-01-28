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
            <p class="text-sm text-gray-500">Absensi siswa bimbingan PKL</p>
        </div>
    </div>

    {{-- FILTER & DOWNLOAD --}}
    <div class="bg-white p-4 rounded shadow flex flex-col md:flex-row md:items-center md:justify-between gap-3">
        <form method="GET"
              action="{{ route('guru.absensi.download') }}"
              class="flex items-center gap-2">

            <input type="month"
                   name="bulan"
                   value="{{ request('bulan', now()->format('Y-m')) }}"
                   class="border rounded p-2">

            <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                Download Excel
            </button>
        </form>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full text-sm border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-3 py-2 text-left">Tanggal</th>
                    <th class="border px-3 py-2 text-left">Nama Siswa</th>
                    <th class="border px-3 py-2 text-left">Status</th>
                    <th class="border px-3 py-2 text-left">Check In</th>
                    <th class="border px-3 py-2 text-left">Check Out</th>
                    <th class="border px-3 py-2 text-left">Lokasi</th>
                    <th class="border px-3 py-2 text-left">Tempat PKL</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($absensi as $absen)
                <tr class="hover:bg-gray-50">
                    <td class="border px-3 py-2">
                        {{ \Carbon\Carbon::parse($absen->tanggal)->format('d-m-Y') }}
                    </td>

                    <td class="border px-3 py-2">
                        {{ $absen->siswa->nama }}
                    </td>

                    <td class="border px-3 py-2 font-semibold">
                        @if($absen->status === 'izin')
                            <span class="text-yellow-600">Izin</span>
                        @elseif($absen->check_in)
                            <span class="text-green-600">Hadir</span>
                        @else
                            <span class="text-red-600">Alpha</span>
                        @endif
                    </td>

                    <td class="border px-3 py-2">
                        {{ $absen->check_in ?? '-' }}
                    </td>

                    <td class="border px-3 py-2">
                        {{ $absen->check_out ?? '-' }}
                    </td>

                    <td class="border px-3 py-2 text-xs text-gray-600">
                        {{ $absen->latitude }},
                        {{ $absen->longitude }}
                    </td>

                    <td class="border px-3 py-2">
                        {{ $absen->siswa->tempatPkl->nama ?? '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-6 text-gray-500">
                        Tidak ada data absensi
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div>
        {{ $absensi->links() }}
    </div>

</div>
@endsection
