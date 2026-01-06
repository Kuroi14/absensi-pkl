@extends('layouts.app')
@section('content')

<form method="POST">@csrf
<input name="nama" placeholder="Nama">
<input name="username">
<input name="password">
<select name="role">
<option>admin</option>
<option>guru</option>
<option>siswa</option>
</select>
<button>Simpan</button>
</form>

<table>
@foreach($users as $u)
<tr><td>{{ $u->nama }}</td></tr>
@endforeach
</table>

@endsection
