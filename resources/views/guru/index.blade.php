@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">Master Guru</h1>

@if(session('success'))
<div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
    {{ session('success') }}
</div>
@endif

<form method="POST" class="bg-white p-4 rounded shadow mb-6 grid grid-cols-2 gap-4">
@csrf
<input name="nip" placeholder="NIP" required class="border p-2">
<input name="nama" placeholder="Nama Guru" required class="border p-2">
<input name="username" placeholder="Username Login" required class="border p-2">
<input name="password" placeholder="Password Login" required class="border p-2">
<input name="mapel" placeholder="Mapel" class="border p-2">
<input name="no_hp" placeholder="No HP" class="border p-2">

<button class="col-span-2 bg-blue-600 text-white py-2 rounded">
    Simpan Guru
</button>
</form>

<table class="w-full bg-white rounded shadow">
<thead class="bg-gray-200">
<tr>
<th class="p-2">NIP</th>
<th class="p-2">Nama</th>
<th class="p-2">Username</th>
<th class="p-2">Mapel</th>
<th class="p-2">Aksi</th>
</tr>
</thead>
<tbody>
@foreach($gurus as $g)
<tr class="border-t">
<td class="p-2">{{ $g->nip }}</td>
<td class="p-2">{{ $g->nama }}</td>
<td class="p-2">{{ $g->user->username }}</td>
<td class="p-2">{{ $g->mapel }}</td>
<td class="p-2">
<form method="POST" action="/guru/{{ $g->id }}">
@csrf
@method('DELETE')
<button class="text-red-600">Hapus</button>
</form>
</td>
</tr>
@endforeach
</tbody>
</table>
@endsection
