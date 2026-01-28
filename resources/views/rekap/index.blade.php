@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="bg-white p-5 rounded-xl shadow flex items-center justify-between">
        <div class="flex items-center gap-4">
            <span class="w-12 h-12 flex items-center justify-center
                         rounded-lg bg-blue-100 text-blue-600">
                <span class="material-symbols-outlined text-3xl">
                    calendar_month
                </span>
            </span>

            <div>
                <h2 class="text-xl font-bold text-gray-800">
                    Rekap Bulanan Absensi PKL
                </h2>
                <p class="text-sm text-gray-500">
                    Rekap kehadiran siswa per bulan dan tahun
                </p>
            </div>
        </div>
    </div>

    {{-- FILTER --}}
    <div class="bg-white rounded-xl shadow p-4 flex flex-wrap items-center gap-3">
        <form method="GET" class="flex flex-wrap items-center gap-3">

            <select name="bulan"
                    class="border rounded-lg p-2 text-sm">
                @for($i=1;$i<=12;$i++)
                    <option value="{{ $i }}" {{ $bulan==$i?'selected':'' }}>
                        {{ date('F', mktime(0,0,0,$i,1)) }}
                    </option>
                @endfor
            </select>

            <select name="tahun"
                    class="border rounded-lg p-2 text-sm">
                @for($y=date('Y')-2;$y<=date('Y');$y++)
                    <option value="{{ $y }}" {{ $tahun==$y?'selected':'' }}>
                        {{ $y }}
                    </option>
                @endfor
            </select>

            <button
                class="bg-blue-600 hover:bg-blue-700
                       text-white px-4 py-2 rounded-lg
                       text-sm transition">
                Tampilkan
            </button>

            <a href="/rekap/bulanan/excel?bulan={{ $bulan }}"
               class="bg-green-600 hover:bg-green-700
                      text-white px-4 py-2 rounded-lg
                      text-sm transition">
                Export Excel
            </a>
        </form>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="border px-4 py-3 text-left">NIS</th>
                        <th class="border px-4 py-3 text-left">Nama</th>
                        <th class="border px-4 py-3 text-left">Kelas</th>
                        <th class="border px-4 py-3 text-left">Tempat PKL</th>
                        <th class="border px-4 py-3 text-center">Hadir</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($rekap as $r)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="border px-4 py-2">
                            {{ $r->nis }}
                        </td>
                        <td class="border px-4 py-2 font-medium">
                            {{ $r->nama }}
                        </td>
                        <td class="border px-4 py-2">
                            {{ $r->kelas }}
                        </td>
                        <td class="border px-4 py-2">
                            {{ $r->tempat_pkl }}
                        </td>
                        <td class="border px-4 py-2 text-center font-semibold">
                            {{ $r->hadir }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5"
                            class="border px-4 py-6 text-center text-gray-500">
                            Data tidak ditemukan
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
