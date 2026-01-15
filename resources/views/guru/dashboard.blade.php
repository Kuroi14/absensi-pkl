@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold">Dashboard Guru</h1>
    <p>Selamat datang di dashboard guru.</p>
</div>
@endsection

<table class="w-full bg-white rounded shadow">
<thead class="bg-gray-200">
<tr>
    <th class="p-2">NIS</th>
    <th class="p-2">Nama Siswa</th>
    <th class="p-2">Kelas</th>
    <th class="p-2">Check In</th>
    <th class="p-2">Check Out</th>
    <th class="p-2">Lokasi</th>
    <th class="p-2">Foto</th>
</tr>
</thead>
<tbody>
@forelse($absensis as $a)
<tr class="border-t">
    <td class="p-2">{{ $a->siswa->nis }}</td>
    <td class="p-2">{{ $a->siswa->nama }}</td>
    <td class="p-2">{{ $a->siswa->kelas }}</td>
    <td class="p-2">{{ $a->check_in_time ?? '-' }}</td>
    <td class="p-2">{{ $a->check_out_time ?? '-' }}</td>
    <td class="p-2 text-sm">
        IN: {{ $a->check_in_lat }}, {{ $a->check_in_lng }}<br>
        OUT: {{ $a->check_out_lat }}, {{ $a->check_out_lng }}
    </td>
    <td class="p-2">
        @if($a->check_in_foto)
            <a href="{{ asset('storage/'.$a->check_in_foto) }}" target="_blank">
                <img src="{{ asset('storage/'.$a->check_in_foto) }}"
                     class="w-12 h-12 object-cover rounded">
            </a>
        @endif
        </td>
    </tr>
@empty
<tr>
    <td colspan="7" class="p-4 text-center text-gray-500">
        Belum ada absensi hari ini
    </td>
</tr>
@endforelse
</tbody>
</table>

