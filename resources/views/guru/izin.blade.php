@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded shadow">
<h2 class="text-xl font-semibold mb-4">Persetujuan Izin Siswa</h2>

@if(session('success'))
<div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
{{ session('success') }}
</div>
@endif

<table class="w-full border-collapse">
<thead class="bg-gray-100">
<tr>
    <th class="p-3 text-left">Nama</th>
    <th class="p-3 text-left">Tanggal</th>
    <th class="p-3 text-left">Jenis</th>
    <th class="p-3 text-left">Alasan</th>
    <th class="p-3 text-center">Aksi</th>
</tr>
</thead>
<tbody>
@foreach($izins as $i)
<tr class="border-b">
    <td class="p-3">{{ $i->siswa->nama }}</td>
    <td class="p-3">{{ $i->tanggal }}</td>
    <td class="p-3 capitalize">{{ $i->jenis }}</td>
    <td class="p-3">{{ $i->alasan }}</td>
    <td class="p-3 text-center space-x-2">
        @if($i->status == 'pending')
        <form method="POST" action="{{ url('/guru/izin/'.$i->id.'/approve') }}" class="inline">
            @csrf
            <button class="bg-green-600 text-white px-3 py-1 rounded text-sm">
                Setujui
            </button>
        </form>

        <form method="POST" action="{{ url('/guru/izin/'.$i->id.'/reject') }}" class="inline">
            @csrf
            <button class="bg-red-600 text-white px-3 py-1 rounded text-sm">
                Tolak
            </button>
        </form>
        @else
            <span class="text-gray-500 text-sm">{{ $i->status }}</span>
        @endif
    </td>
</tr>
@endforeach
</tbody>
</table>
</div>
@endsection
