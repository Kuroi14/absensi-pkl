@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Master Siswa</h1>

@if(session('success'))
<div class="bg-green-100 p-2 mb-4">{{ session('success') }}</div>
@endif

<form method="POST" class="grid grid-cols-3 gap-3 bg-white p-4 rounded shadow mb-6">
@csrf
<input name="nis" placeholder="NIS" required class="border p-2">
<input name="nama" placeholder="Nama" required class="border p-2">
<input name="kelas" placeholder="Kelas" required class="border p-2">

<input name="username" placeholder="Username" required class="border p-2">
<input name="password" placeholder="Password" required class="border p-2">

<select name="guru_id" class="border p-2">
@foreach($gurus as $g)
<option value="{{ $g->id }}">{{ $g->nama }}</option>
@endforeach
</select>

<select name="tempat_pkl_id" class="border p-2">
@foreach($tempatPkls as $t)
<option value="{{ $t->id }}">{{ $t->nama }}</option>
@endforeach
</select>

<button class="col-span-3 bg-blue-600 text-white py-2 rounded">
Simpan Siswa
</button>
</form>

<table class="w-full bg-white shadow rounded">
<thead class="bg-gray-200">
<tr>
<th>NIS</th><th>Nama</th><th>Kelas</th><th>Guru</th><th>PKL</th><th>Aksi</th>
</tr>
</thead>
<tbody>
@foreach($siswas as $s)
<tr class="border-t">
<td>{{ $s->nis }}</td>
<td>{{ $s->nama }}</td>
<td>{{ $s->kelas }}</td>
<td>{{ $s->guru->nama }}</td>
<td>{{ $s->tempatPkl->nama }}</td>
<td>
<form method="POST" action="/siswa/{{ $s->id }}">
@csrf @method('DELETE')
<button class="text-red-600">Hapus</button>
</form>
</td>
</tr>
@endforeach
</tbody>
</table>
@endsection
