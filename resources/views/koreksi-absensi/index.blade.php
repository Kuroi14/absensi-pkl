@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow p-6">

    <h2 class="text-xl font-semibold mb-4">Koreksi Absensi</h2>

    {{-- FLASH MESSAGE --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
            {{ session('error') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full border text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-3 border">Tanggal</th>
                    <th class="p-3 border">NIS</th>
                    <th class="p-3 border">Nama</th>
                    <th class="p-3 border">Check In</th>
                    <th class="p-3 border">Check Out</th>
                    <th class="p-3 border">Status</th>
                    <th class="p-3 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($absensis as $a)
                <tr class="border-b hover:bg-gray-50">

                    <td class="p-3 border">
                        {{ \Carbon\Carbon::parse($a->tanggal)->format('d-m-Y') }}
                    </td>

                    <td class="p-3 border">{{ $a->siswa->nis ?? '-' }}</td>

                    <td class="p-3 border">{{ $a->siswa->nama ?? '-' }}</td>

                    <td class="p-3 border">
                        {{ $a->check_in_time ?? '-' }}
                        @if($a->koreksi && $a->koreksi->check_in_time)
                            <div class="text-xs text-blue-600">
                                → {{ $a->koreksi->check_in_time }}
                            </div>
                        @endif
                    </td>

                    <td class="p-3 border">
                        {{ $a->check_out_time ?? '-' }}
                        @if($a->koreksi && $a->koreksi->check_out_time)
                            <div class="text-xs text-blue-600">
                                → {{ $a->koreksi->check_out_time }}
                            </div>
                        @endif
                    </td>

                    <td class="p-3 border text-center">
                        @if(!$a->koreksi)
                            <span class="px-2 py-1 bg-gray-200 rounded text-xs">
                                Tidak ada koreksi
                            </span>
                        @elseif($a->koreksi->status == 'pending')
                            <span class="px-2 py-1 bg-yellow-200 text-yellow-800 rounded text-xs">
                                Pending
                            </span>
                        @elseif($a->koreksi->status == 'disetujui')
                            <span class="px-2 py-1 bg-green-200 text-green-800 rounded text-xs">
                                Disetujui
                            </span>
                        @else
                            <span class="px-2 py-1 bg-red-200 text-red-800 rounded text-xs">
                                Ditolak
                            </span>
                        @endif
                    </td>

                    <td class="p-3 border text-center space-x-2">

                        {{-- DETAIL --}}
                        @if($a->koreksi)
                            <button
                                onclick="alert('{{ $a->koreksi->alasan }}')"
                                class="px-3 py-1 bg-blue-500 text-white rounded text-xs">
                                Lihat Alasan
                            </button>
                        @endif

                        {{-- APPROVE / REJECT --}}
                        @if($a->koreksi && $a->koreksi->status == 'pending')

                            <form method="POST"
                                  action="{{ route('admin.koreksi-absensi.approve', $a->koreksi->id) }}"
                                  class="inline">
                                @csrf
                                @method('PUT')
                                <button class="px-3 py-1 bg-green-600 text-white rounded text-xs">
                                    Setujui
                                </button>
                            </form>

                            <form method="POST"
                                  action="{{ route('admin.koreksi-absensi.reject', $a->koreksi->id) }}"
                                  class="inline">
                                @csrf
                                @method('PUT')
                                <button class="px-3 py-1 bg-red-600 text-white rounded text-xs">
                                    Tolak
                                </button>
                            </form>

                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="p-4 text-center text-gray-500">
                        Tidak ada data absensi
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

