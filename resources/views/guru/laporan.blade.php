@extends('layouts.app')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="bg-white p-5 rounded-lg shadow flex items-center gap-4">
        <span class="w-12 h-12 flex items-center justify-center
                     rounded-lg bg-indigo-100 text-indigo-600">
            <span class="material-symbols-outlined text-3xl">
                summarize
            </span>
        </span>

        <div>
            <h2 class="text-xl font-bold text-gray-800">
                Laporan Kehadiran
            </h2>
            <p class="text-sm text-gray-500">
                Rekap kehadiran siswa PKL berdasarkan bulan
            </p>
        </div>
    </div>

    {{-- FILTER --}}
    <div class="bg-white p-4 rounded-lg shadow">
        <form method="GET" class="flex flex-col md:flex-row gap-3 items-start md:items-center">
            <select name="bulan"
                    class="border rounded px-3 py-2 focus:outline-none focus:ring w-full md:w-56">
                <option value="">-- Pilih Bulan --</option>
                @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}"
                        {{ request('bulan') == $i ? 'selected' : '' }}>
                        Bulan {{ $i }}
                    </option>
                @endfor
            </select>

            <button
                class="bg-blue-600 text-white px-5 py-2 rounded
                       hover:bg-blue-700 transition">
                Filter
            </button>
        </form>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="border px-4 py-3 text-left">Nama</th>
                        <th class="border px-4 py-3 text-left">Tanggal</th>
                        <th class="border px-4 py-3 text-center">Status</th>
                        <th class="border px-4 py-3 text-center">Masuk</th>
                        <th class="border px-4 py-3 text-center">Pulang</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($absensis as $s)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="border px-4 py-2 font-medium">
                            {{ $s->siswa->nama }}
                        </td>

                        <td class="border px-4 py-2">
                            {{ $s->tanggal }}
                        </td>

                        {{-- STATUS BADGE --}}
                        <td class="border px-4 py-2 text-center capitalize">
                            @if($s->status === 'hadir')
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                             bg-green-100 text-green-700">
                                    Hadir
                                </span>
                            @elseif($s->status === 'izin')
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                             bg-yellow-100 text-yellow-700">
                                    Izin
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                             bg-red-100 text-red-700">
                                    {{ $s->status }}
                                </span>
                            @endif
                        </td>

                        <td class="border px-4 py-2 text-center">
                            {{ $s->jam_masuk ?? '-' }}
                        </td>

                        <td class="border px-4 py-2 text-center">
                            {{ $s->jam_pulang ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-gray-500">
                            Data kehadiran belum tersedia
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
