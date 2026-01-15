@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-4"
     x-data="absensi()"
     x-init="getLocation()">

    <h1 class="text-xl font-bold">Absensi PKL</h1>

    {{-- STATUS JARAK --}}
    <div class="bg-white rounded shadow p-4 flex justify-between items-center">
        <div>
            <p class="text-sm text-gray-600">Jarak ke lokasi PKL</p>
            <p class="text-lg font-bold"
               :class="jarak <= radius ? 'text-green-600' : 'text-red-600'">
                <span x-text="Math.round(jarak)"></span> meter
            </p>
        </div>

        <span
            class="px-3 py-1 rounded-full text-sm font-semibold flex items-center gap-2"
            :class="jarak <= radius 
                ? 'bg-green-100 text-green-700' 
                : 'bg-red-100 text-red-700'">

            <span 
                class="w-2 h-2 rounded-full animate-pulse"
                :class="jarak <= radius ? 'bg-green-600' : 'bg-red-600'">
            </span>

            <span x-text="jarak <= radius ? 'Dalam Radius PKL' : 'Di Luar Radius PKL'"></span>
        </span>
    </div>

    <p class="text-xs text-gray-500" x-show="jarak <= radius">
        Anda berada dalam jarak yang diizinkan untuk absensi.
    </p>

    <p class="text-xs text-red-600" x-show="jarak > radius">
        Anda terlalu jauh dari lokasi PKL. Mendekatlah untuk melakukan absensi.
    </p>

    {{-- MAP --}}
    <div class="bg-white rounded shadow overflow-hidden">
        <div id="map" class="h-64 w-full"></div>
    </div>

    {{-- FORM ABSENSI --}}
    <div class="bg-white rounded shadow p-4 space-y-3">
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-2 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-2 rounded">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" enctype="multipart/form-data"
              action="{{ $absen ? '/absensi/check-out' : '/absensi/check-in' }}">
            @csrf

            <input type="hidden" name="lat" x-model="lat">
            <input type="hidden" name="lng" x-model="lng">

            <label class="block text-sm font-medium">Foto Absensi</label>
            <input type="file" name="foto" required
                   class="border rounded w-full p-2">

            <button
                class="mt-3 w-full bg-blue-600 text-white py-2 rounded font-semibold transition-all duration-300"
                :disabled="jarak > radius"
                :class="jarak > radius 
                    ? 'opacity-50 cursor-not-allowed bg-gray-400' 
                    : 'hover:bg-blue-700'">
                {{ $absen ? 'Check Out' : 'Check In' }}
            </button>
        </form>
    </div>

</div>

{{-- LEAFLET --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
let map, markerSiswa, circleRadius;

function absensi(){
    return {
        lat: null,
        lng: null,
        jarak: 0,

        radius: {{ $siswa->tempatPkl->radius }},
        latPkl: {{ $siswa->tempatPkl->latitude }},
        lngPkl: {{ $siswa->tempatPkl->longitude }},

        getLocation(){
            map = L.map('map').setView([this.latPkl, this.lngPkl], 17);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{
                attribution:'© OpenStreetMap'
            }).addTo(map);

            L.marker([this.latPkl, this.lngPkl])
                .addTo(map)
                .bindPopup("Lokasi PKL");

            circleRadius = L.circle(
                [this.latPkl, this.lngPkl],
                {
                    radius: this.radius,
                    color: 'green',
                    fillOpacity: 0.2
                }
            ).addTo(map);

            navigator.geolocation.watchPosition(pos=>{
                this.lat = pos.coords.latitude;
                this.lng = pos.coords.longitude;

                this.hitungJarak();

                if(markerSiswa){
                    markerSiswa.setLatLng([this.lat,this.lng]);
                } else {
                    markerSiswa = L.marker([this.lat,this.lng])
                        .addTo(map)
                        .bindPopup("Posisi Anda");
                }

                // Update warna radius
                circleRadius.setStyle({
                    color: this.jarak <= this.radius ? 'green' : 'red'
                });
            });
        },

        hitungJarak(){
            const R = 6371000;
            const dLat = (this.latPkl - this.lat) * Math.PI / 180;
            const dLng = (this.lngPkl - this.lng) * Math.PI / 180;
            const a =
                Math.sin(dLat/2) ** 2 +
                Math.cos(this.lat * Math.PI/180) *
                Math.cos(this.latPkl * Math.PI/180) *
                Math.sin(dLng/2) ** 2;

            this.jarak = R * (2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)));
        }
    }
}
</script>
@endsection
