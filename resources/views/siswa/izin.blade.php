@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Pengajuan Izin</h2>

<form method="POST">
@csrf
<input type="date" name="tanggal" required>
<select name="jenis">
    <option value="sakit">Sakit</option>
    <option value="izin">Izin</option>
</select>
<textarea name="keterangan" placeholder="Keterangan"></textarea>
<button>Kirim</button>
</form>
@endsection
