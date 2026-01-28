@extends('layouts.app')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="bg-white p-5 rounded-lg shadow flex items-center gap-4">
        <span class="w-12 h-12 flex items-center justify-center rounded-lg
                     bg-blue-100 text-blue-600">
            <span class="material-symbols-outlined text-3xl">
                history
            </span>
        </span>

        <div>
            <h2 class="text-xl font-bold text-gray-800">
                Riwayat Pengajuan Izin
            </h2>
            <p class="text-sm text-gray-500">
                Status pengajuan izin kamu
            </p>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="border px-4 py-3 text-left">Tanggal</th>
                        <th class="border px-4 py-3 text-left">Jenis</th>
                        <th class="border px-4 py-3 text-left">Keterangan</th>
                        <th class="border px-4 py-3 text-center">Bukti</th>
                        <th class="border px-4 py-3 text-center">Status</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($izins as $izin)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="border px-4 py-2">
                            {{ \Carbon\Carbon::parse($izin->tanggal)->format('d-m-Y') }}
                        </td>

                        <td class="border px-4 py-2 capitalize font-medium">
                            {{ $izin->jenis }}
                        </td>

                        <td class="border px-4 py-2 text-gray-600">
                            {{ $izin->keterangan ?? '-' }}
                        </td>

                        {{-- BUKTI --}}
                        <td class="border px-4 py-2 text-center">
                            @if($izin->bukti)
                                <a href="{{ asset('storage/'.$izin->bukti) }}"
                                   target="_blank"
                                   class="text-blue-600 hover:underline text-sm">
                                    Lihat
                                </a>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>

                        {{-- STATUS --}}
                        <td class="border px-4 py-2 text-center">
                            @if($izin->status === 'pending')
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                             bg-yellow-100 text-yellow-700">
                                    Pending
                                </span>
                            @elseif($izin->status === 'approved')
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                             bg-green-100 text-green-700">
                                    Disetujui
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                             bg-red-100 text-red-700">
                                    Ditolak
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5"
                            class="text-center py-6 text-gray-500">
                            Belum ada pengajuan izin
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
