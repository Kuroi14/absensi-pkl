@extends('layouts.app')

@section('content')
<div class="space-y-4">

    {{-- HEADER --}}
    <div class="bg-white p-5 rounded shadow flex items-center gap-3">
        <span class="w-12 h-12 flex items-center justify-center rounded-lg bg-blue-100 text-blue-600">
            <span class="material-symbols-outlined text-3xl">
                fact_check
            </span>
        </span>

        <div>
            <h2 class="text-xl font-bold">Riwayat Koreksi Absensi</h2>
            <p class="text-sm text-gray-500">
                Pengajuan koreksi absensi siswa
            </p>
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
                    <th class="border px-3 py-2 text-left">Alasan</th>
                    <th class="border px-3 py-2 text-left">Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse($koreksis as $koreksi)
                <tr class="hover:bg-gray-50">
                    <td class="border px-3 py-2">
                        {{ \Carbon\Carbon::parse($koreksi->tanggal)->format('d-m-Y') }}
                    </td>

                    <td class="border px-3 py-2">
                        {{ $koreksi->check_in_time ?? '-' }}
                    </td>

                    <td class="border px-3 py-2">
                        {{ $koreksi->check_out_time ?? '-' }}
                    </td>

                    <td class="border px-3 py-2">
                        {{ $koreksi->alasan }}
                    </td>

                    <td class="border px-3 py-2 font-semibold">
                        @if($koreksi->status === 'pending')
                            <span class="text-yellow-600">Menunggu</span>
                        @elseif($koreksi->status === 'disetujui')
                            <span class="text-green-600">Disetujui</span>
                        @else
                            <span class="text-red-600">Ditolak</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-6 text-gray-500">
                        Belum ada pengajuan koreksi
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
