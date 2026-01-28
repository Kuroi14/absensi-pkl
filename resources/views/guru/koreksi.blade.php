@extends('layouts.app')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="bg-white p-5 rounded-lg shadow flex items-center gap-4">
        <span class="w-12 h-12 flex items-center justify-center rounded-lg
                     bg-yellow-100 text-yellow-600">
            <span class="material-symbols-outlined text-3xl">
                assignment_late
            </span>
        </span>

        <div>
            <h2 class="text-xl font-bold text-gray-800">
                Monitoring Izin Siswa
            </h2>
            <p class="text-sm text-gray-500">
                Persetujuan izin siswa bimbingan PKL
            </p>
        </div>
    </div>

    {{-- TABLE CARD --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="border px-4 py-3 text-left">Nama</th>
                        <th class="border px-4 py-3 text-left">Tanggal</th>
                        <th class="border px-4 py-3 text-left">Jenis</th>
                        <th class="border px-4 py-3 text-left">Keterangan</th>
                        <th class="border px-4 py-3 text-center">Status</th>
                        <th class="border px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($izins as $i)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="border px-4 py-2 font-medium">
                            {{ $i->siswa->nama }}
                        </td>

                        <td class="border px-4 py-2">
                            {{ \Carbon\Carbon::parse($i->tanggal)->format('d-m-Y') }}
                        </td>

                        <td class="border px-4 py-2 capitalize">
                            {{ $i->jenis }}
                        </td>

                        <td class="border px-4 py-2 text-gray-600">
                            {{ $i->keterangan ?? '-' }}
                        </td>

                        {{-- STATUS BADGE --}}
                        <td class="border px-4 py-2 text-center">
                            @if($i->status === 'pending')
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                             bg-yellow-100 text-yellow-700">
                                    Pending
                                </span>
                            @elseif($i->status === 'approved')
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

                        {{-- AKSI --}}
                        <td class="border px-4 py-2 text-center">
                            @if($i->status === 'pending')
                                <div class="flex justify-center gap-2">
                                    <form method="POST"
                                          action="{{ route('admin.izin.approve',$i->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <button
                                            class="px-3 py-1 text-sm rounded
                                                   bg-green-600 text-white
                                                   hover:bg-green-700 transition">
                                            Setujui
                                        </button>
                                    </form>

                                    <form method="POST"
                                          action="{{ route('admin.izin.reject',$i->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <button
                                            class="px-3 py-1 text-sm rounded
                                                   bg-red-600 text-white
                                                   hover:bg-red-700 transition">
                                            Tolak
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="text-gray-400 text-sm">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6"
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
