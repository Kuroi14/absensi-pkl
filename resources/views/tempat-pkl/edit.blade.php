@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">

<h1 class="text-xl font-bold mb-4">Edit Tempat PKL</h1>

<form method="POST"
      action="{{ route('admin.tempat-pkl.update',$tempat->id) }}">
@csrf
@method('PUT')

<input type="text" name="nama" value="{{ $tempat->nama }}" class="w-full border p-2 mb-3">
<textarea name="alamat" class="w-full border p-2 mb-3">{{ $tempat->alamat }}</textarea>
<input type="text" name="latitude" value="{{ $tempat->latitude }}" class="w-full border p-2 mb-3">
<input type="text" name="longitude" value="{{ $tempat->longitude }}" class="w-full border p-2 mb-3">
<input type="number" name="radius" value="{{ $tempat->radius }}" class="w-full border p-2 mb-3">

<button class="bg-blue-600 text-white px-4 py-2 rounded">
Update
</button>

</form>
</div>
@endsection
