@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">

<h2 class="text-xl font-bold mb-4">Tambah Tempat PKL</h2>

<form method="POST" action="{{ route('admin.tempat-pkl.store') }}">
@csrf

<div class="grid grid-cols-2 gap-4 mb-4">
    <input name="nama" placeholder="Nama Bengkel" class="border p-2 rounded" required>
    <input name="pembimbing" placeholder="Pembimbing" class="border p-2 rounded">
    <input name="telp" placeholder="No. Telp" class="border p-2 rounded">
    <input name="radius" id="radius" placeholder="Radius (meter)" value="100"
           class="border p-2 rounded" required>
</div>

<textarea name="alamat" placeholder="Alamat lengkap"
          class="border p-2 rounded w-full mb-4"></textarea>

<!-- LAT LNG -->
<input type="hidden" name="latitude" id="latitude">
<input type="hidden" name="longitude" id="longitude">

<!-- SEARCH -->
<div class="flex gap-2 mb-3">
    <input type="text"
           id="search"
           placeholder="Cari alamat / nama tempat"
           class="border p-2 rounded w-full">

    <button type="button"
            onclick="searchAddress()"
            class="bg-green-600 text-white px-4 rounded">
        Cari
    </button>
</div>

<!-- MAP -->
<div id="map" class="w-full h-[350px] rounded border mb-4"></div>

<button class="bg-blue-600 text-white px-4 py-2 rounded">
    Simpan
</button>

</form>
</div>

<script>
let map = L.map('map').setView([-7.55, 112.22], 13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap'
}).addTo(map);

let marker = null;
let circle = null;

// Klik map
map.on('click', function(e) {
    setMarker(e.latlng.lat, e.latlng.lng);
});

// Cari alamat
function searchAddress() {
    let query = document.getElementById('search').value;
    if (!query) return;

    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}`)
    .then(res => res.json())
    .then(data => {
        if (data.length === 0) {
            alert('Alamat tidak ditemukan');
            return;
        }

        let lat = data[0].lat;
        let lng = data[0].lon;

        map.setView([lat, lng], 16);
        setMarker(lat, lng);
    });
}

// Set marker + radius
function setMarker(lat, lng) {
    document.getElementById('latitude').value = lat;
    document.getElementById('longitude').value = lng;

    if (marker) map.removeLayer(marker);
    if (circle) map.removeLayer(circle);

    marker = L.marker([lat, lng], { draggable: true }).addTo(map);

    let radius = document.getElementById('radius').value || 100;

    circle = L.circle([lat, lng], {
        radius: radius,
        color: 'blue',
        fillOpacity: 0.2
    }).addTo(map);

    marker.on('dragend', function (e) {
        let pos = e.target.getLatLng();
        document.getElementById('latitude').value = pos.lat;
        document.getElementById('longitude').value = pos.lng;
        circle.setLatLng(pos);
    });
}

// Radius realtime
document.getElementById('radius').addEventListener('input', function () {
    if (circle) circle.setRadius(this.value);
});

// 🔥 FIX TAILWIND + FLEX BUG
setTimeout(() => {
    map.invalidateSize();
}, 400);
</script>
@endsection
