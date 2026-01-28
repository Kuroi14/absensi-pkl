@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto space-y-6"
     x-data="absensi()"
     x-init="initMap()">

    {{-- HEADER --}}
    <div class="bg-white p-5 rounded-lg shadow flex items-center gap-4">
        <span class="w-12 h-12 flex items-center justify-center rounded-lg bg-blue-100 text-blue-600">
            <span class="material-symbols-outlined text-3xl">fingerprint</span>
        </span>
        <div>
            <h1 class="text-xl font-bold text-gray-800">Absensi PKL</h1>
            <p class="text-sm text-gray-500">Check-in & Check-out berbasis lokasi</p>
        </div>
    </div>

    {{-- STATUS --}}
    <div class="bg-white rounded-lg shadow p-4 flex justify-between items-center">
        <div>
            <p class="text-sm text-gray-500">Jarak ke lokasi PKL</p>
            <p class="text-2xl font-bold"
               :class="jarak <= radius ? 'text-green-600' : 'text-red-600'">
                <span x-text="Math.round(jarak)"></span> m
            </p>
            <p class="text-xs text-gray-500 mt-2">
                Akurasi GPS: <span x-text="Math.round(accuracy)"></span> m
            </p>
            <p class="text-xs text-gray-500 mt-2">
                Check-in Pukul 06.00-12.00<br>
                Check-out Pukul 15.00-18.00
            </p>
        </div>

        <span class="px-4 py-1 rounded-full text-sm font-semibold"
              :class="jarak <= radius ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'">
            <span x-text="jarak <= radius ? 'Dalam Radius PKL' : 'Di Luar Radius PKL'"></span>
        </span>
    </div>

    {{-- MAP --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div id="map" class="h-72 w-full"></div>
    </div>

    {{-- FORM --}}
    <div class="bg-white rounded-lg shadow p-4 space-y-4">

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST"
              enctype="multipart/form-data"
              action="{{ $absen ? route('siswa.absensi.check-out') : route('siswa.absensi.check-in') }}">
            @csrf

            <input type="hidden" name="lat" x-model="lat">
            <input type="hidden" name="lng" x-model="lng">
            <input type="hidden" name="accuracy" x-model="accuracy">

            <div>
                <label class="block text-sm font-medium mb-1">Foto Absensi</label>
                <input type="file" name="foto" required
                       class="border rounded-lg w-full p-2 text-sm">
            </div>

            <button
                class="w-full py-2 rounded-lg font-semibold transition"
                :disabled="!locationReady || jarak > radius + 25"
                :class="(!locationReady || jarak > radius + 25)
                    ? 'bg-gray-400 cursor-not-allowed'
                    : 'bg-blue-600 hover:bg-blue-700 text-white'">
                {{ $absen ? 'Check Out' : 'Check In' }}
            </button>

            <p class="text-xs text-yellow-600 mt-2" x-show="accuracy > 80">
                Akurasi GPS kurang baik (±<span x-text="Math.round(accuracy)"></span> m).
                Tunggu beberapa detik.
            </p>

        </form>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
let map, markerSiswa, circleRadius;

function absensi() {
    return {
        lat: null,
        lng: null,
        accuracy: 999,
        jarak: 0,
        locationReady: false,

        radius: {{ $siswa->tempatPkl->radius }},
        latPkl: {{ $siswa->tempatPkl->latitude }},
        lngPkl: {{ $siswa->tempatPkl->longitude }},

        initMap() {
            this.$nextTick(() => {
                map = L.map('map').setView([this.latPkl, this.lngPkl], 17);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

                L.marker([this.latPkl, this.lngPkl])
                    .addTo(map)
                    .bindPopup('Lokasi PKL');

                circleRadius = L.circle([this.latPkl, this.lngPkl], {
                    radius: this.radius,
                    color: 'green',
                    fillOpacity: 0.2
                }).addTo(map);

                setTimeout(() => map.invalidateSize(), 300);
                this.startTracking();
            });
        },

        startTracking() {
            navigator.geolocation.watchPosition(
                pos => {
                    this.lat = pos.coords.latitude;
                    this.lng = pos.coords.longitude;
                    this.accuracy = pos.coords.accuracy;

                    this.hitungJarak();
                    this.locationReady = true;

                    if (!markerSiswa) {
                        markerSiswa = L.marker([this.lat, this.lng]).addTo(map);
                    } else {
                        markerSiswa.setLatLng([this.lat, this.lng]);
                    }

                    markerSiswa.bindPopup(
                        `Posisi Anda<br>Akurasi: ±${Math.round(this.accuracy)} m`
                    );

                    circleRadius.setStyle({
                        color: this.jarak <= this.radius ? 'green' : 'red'
                    });
                },
                err => alert(err.message),
                {
                    enableHighAccuracy: true,
                    maximumAge: 5000,
                    timeout: 20000
                }
            );
        },

        hitungJarak() {
            const R = 6371000;
            const toRad = deg => deg * Math.PI / 180;

            const dLat = toRad(this.latPkl - this.lat);
            const dLng = toRad(this.lngPkl - this.lng);

            const a =
                Math.sin(dLat/2) ** 2 +
                Math.cos(toRad(this.lat)) *
                Math.cos(toRad(this.latPkl)) *
                Math.sin(dLng/2) ** 2;

            this.jarak = R * (2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)));
        }
    }
  
}
</script>
@endsection
