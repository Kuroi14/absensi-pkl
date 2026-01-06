@extends('layouts.app')

@section('content')
<h1 class="text-xl font-bold mb-4">Absensi PKL</h1>

@if(session('success'))
<div class="bg-green-100 p-2 mb-3">{{ session('success') }}</div>
@endif

<div x-data="absensi()" x-init="getLocation()">

<form method="POST" enctype="multipart/form-data"
      action="{{ $absen ? '/absensi/check-out' : '/absensi/check-in' }}">
@csrf

<input type="hidden" name="lat" x-model="lat">
<input type="hidden" name="lng" x-model="lng">

<input type="file" name="foto" accept="image/*" capture required
       class="border p-2 mb-3 w-full">

@if($errors->any())
<div class="bg-red-100 text-red-700 p-2 mb-3 rounded">
    {{ $errors->first() }}
</div>
@endif

<button class="bg-blue-600 text-white px-4 py-2 rounded w-full">
{{ $absen ? 'Check Out' : 'Check In' }}
</button>

</form>

<p class="text-sm mt-3">Lokasi: <span x-text="lat"></span>, <span x-text="lng"></span></p>

</div>

<script>
function absensi(){
    return {
        lat: '',
        lng: '',
        getLocation(){
            navigator.geolocation.getCurrentPosition(pos=>{
                this.lat = pos.coords.latitude;
                this.lng = pos.coords.longitude;
            });
        }
    }
}
</script>
@endsection
