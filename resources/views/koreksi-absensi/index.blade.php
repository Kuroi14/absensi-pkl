@extends('layouts.app')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="bg-white p-5 rounded-lg shadow flex items-center gap-4">
        <span class="w-12 h-12 flex items-center justify-center rounded-lg
                     bg-blue-100 text-blue-600">
            <span class="material-symbols-outlined text-3xl">
                fact_check
            </span>
        </span>

        <div>
            <h2 class="text-xl font-bold text-gray-800">
                Koreksi Absensi Siswa
            </h2>
            <p class="text-sm text-gray-500">
                Persetujuan pengajuan koreksi absensi siswa PKL
            </p>
        </div>
    </div>

    {{-- ALERT SUCCESS --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE CARD --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="border px-4 py-3 text-left">Siswa</th>
                        <th class="border px-4 py-3 text-left">Tanggal</th>
                        <th class="border px-4 py-3 text-left">Alasan</th>
                        <th class="border px-4 py-3 text-center">Status</th>
                        <th class="border px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($absensis as $absen)
                    @if($absen->koreksi)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="border px-4 py-2 font-medium">
                            {{ $absen->siswa->nama }}
                        </td>

                        <td class="border px-4 py-2">
                            {{ $absen->tanggal }}
                        </td>

                        <td class="border px-4 py-2 text-gray-600">
                            {{ $absen->koreksi->alasan }}
                        </td>

                        {{-- STATUS BADGE --}}
                        <td class="border px-4 py-2 text-center">
                            @if($absen->koreksi->status === 'pending')
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                             bg-yellow-100 text-yellow-700">
                                    Pending
                                </span>
                            @elseif($absen->koreksi->status === 'approved')
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                             bg-green-100 text-green-700">
                                    Approved
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                             bg-red-100 text-red-700">
                                    Rejected
                                </span>
                            @endif
                        </td>

                        {{-- AKSI --}}
                        <td class="border px-4 py-2 text-center">
                            @if($absen->koreksi->status === 'pending')
                                <div class="flex justify-center gap-2">
                                    <form method="POST"
                                          action="{{ route('guru.koreksi-absensi.approve', $absen->koreksi) }}">
                                        @csrf
                                        <button
                                            class="px-3 py-1 text-sm rounded
                                                   bg-green-600 text-white
                                                   hover:bg-green-700 transition">
                                            Approve
                                        </button>
                                    </form>

                                    <form method="POST"
                                          action="{{ route('guru.koreksi-absensi.reject', $absen->koreksi) }}">
                                        @csrf
                                        <button
                                            class="px-3 py-1 text-sm rounded
                                                   bg-red-600 text-white
                                                   hover:bg-red-700 transition">
                                            Reject
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="text-gray-400 text-sm">—</span>
                            @endif
                        </td>
                    </tr>
                    @endif
                    @endforeach
                    @if($absensis->where('koreksi')->isEmpty())
                        <tr class="hover:bg-gray-50 transition">
                            <td colspan="5" class="text-center py-6 text-gray-500"> 
                                Belum ada pengajuan koreksi absensi 
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
