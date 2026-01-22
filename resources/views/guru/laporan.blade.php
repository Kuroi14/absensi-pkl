@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded shadow">
<h2 class="text-xl font-semibold mb-4">Laporan Kehadiran</h2>

<form method="GET" class="mb-4 flex gap-3">
<select name="bulan" class="border p-2 rounded">
<option value="">-- Pilih Bulan --</option>
@for($i=1;$i<=12;$i++)
<option value="{{ $i }}">{{ $i }}</option>
@endfor
</select>

<button class="bg-blue-600 text-white px-4 rounded">
Filter
</button>
</form>

<table class="w-full border-collapse">
<thead class="bg-gray-100">
<tr>
    <th class="p-3">Nama</th>
    <th class="p-3">Tanggal</th>
    <th class="p-3">Status</th>
    <th class="p-3">Masuk</th>
    <th class="p-3">Pulang</th>
</tr>
</thead>

<tbody>
@foreach($absensis as $s)
<tr class="border-b">
    <td class="p-3">{{ $s->siswa->nama }}</td>
    <td class="p-3">{{ $s->tanggal }}</td>
    <td class="p-3 capitalize">{{ $s->status }}</td>
    <td class="p-3">{{ $s->jam_masuk }}</td>
    <td class="p-3">{{ $s->jam_pulang }}</td>
</tr>
@endforeach
</tbody>
</table>
</div>
@endsection
