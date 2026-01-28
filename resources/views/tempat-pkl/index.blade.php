@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="bg-white p-5 rounded-xl shadow flex items-center justify-between">
        <div class="flex items-center gap-4">
            <span class="w-12 h-12 flex items-center justify-center
                         rounded-lg bg-blue-100 text-blue-600">
                <span class="material-symbols-outlined text-3xl">
                    factory
                </span>
            </span>

            <div>
                <h2 class="text-xl font-bold text-gray-800">
                    Data Bengkel
                </h2>
                <p class="text-sm text-gray-500">
                    Kelola data bengkel siswa
                </p>
            </div>
        </div>

        <button onclick="openModal()"
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition">
            + Tambah Bengkel
        </button>
    </div>

    {{-- UPLOAD & DOWNLOAD --}}
    <div class="bg-white rounded-xl shadow p-4 flex flex-wrap items-center gap-3">
        <form action="{{ route('admin.tempat-pkl.import') }}"
              method="POST"
              enctype="multipart/form-data"
              class="flex items-center gap-2">
            @csrf

            <input type="file" name="file" required
                   class="border rounded-lg p-2 text-sm">

            <button
                class="bg-blue-600 hover:bg-blue-700
                       text-white px-4 py-2 rounded-lg
                       text-sm transition">
                Upload Excel
            </button>
        </form>

        <a href="{{ route('admin.tempat-pkl.template') }}"
           class="bg-green-600 hover:bg-green-700
                  text-white px-4 py-2 rounded-lg
                  text-sm transition">
            Download Template
        </a>
    </div>

    {{-- FLASH --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="border px-4 py-3 text-left">Nama</th>
                        <th class="border px-4 py-3 text-left">Pemilik</th>
                        <th class="border px-4 py-3 text-left">Telp</th>
                        <th class="border px-4 py-3 text-left">Alamat</th>
                        <th class="border px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($tempatPkls as $t)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="border px-4 py-2 font-medium">
                            {{ $t->nama }}
                        </td>
                        <td class="border px-4 py-2">
                            {{ $t->pembimbing }}
                        </td>
                        <td class="border px-4 py-2">
                            {{ $t->telp }}
                        </td>
                        <td class="border px-4 py-2 max-w-xs">
                            <div class="truncate" title="{{ $t->alamat }}">
                                {{ $t->alamat }}
                            </div>
                        </td>
                        <td class="border px-4 py-2 text-center">
                            <div class="flex justify-center gap-2">
                                <button onclick="editBengkel({{ $t->id }})"
                                    class="bg-blue-500 hover:bg-blue-600
                                           text-white px-3 py-1 rounded
                                           text-xs transition">
                                    Edit
                                </button>

                                <form method="POST"
                                      action="{{ route('admin.tempat-pkl.destroy',$t->id) }}"
                                      onsubmit="return confirm('Hapus bengkel ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="bg-red-500 hover:bg-red-600
                                               text-white px-3 py-1 rounded
                                               text-xs transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- MODAL --}}
<div id="modalTempatPkl"
     class="fixed inset-0 bg-black bg-opacity-50 hidden
            items-center justify-center z-50">

    <div class="bg-white w-full max-w-5xl rounded-xl shadow p-6">
        <h2 class="text-lg font-bold mb-4 text-gray-700" id="modalTitle">
            Tambah Bengkel
        </h2>

        <form method="POST" id="formBengkel"
              action="{{ route('admin.tempat-pkl.store') }}">
            @csrf
            <input type="hidden" name="_method" id="methodBengkel" value="POST">

            <div class="grid grid-cols-3 gap-3 text-sm mb-4">
                <input name="nama" class="border rounded-lg p-2" placeholder="Nama Bengkel">
                <input name="pembimbing" class="border rounded-lg p-2" placeholder="Pemilik">
                <input name="telp" class="border rounded-lg p-2" placeholder="Telp">

                <input name="radius" id="radius" value="100"
                       class="border rounded-lg p-2" placeholder="Radius">

                <input name="latitude" id="latitude"
       class="border rounded-lg p-2"
       placeholder="Latitude (contoh: -7.556842)"
       step="0.000001">

<input name="longitude" id="longitude"
       class="border rounded-lg p-2"
       placeholder="Longitude (contoh: 112.228991)"
       step="0.000001">

       <p id="kalibrasiInfo" class="text-xs text-gray-600 col-span-3">
    Masukkan koordinat dari GPS lokasi (Google Maps HP)
</p>


                <textarea name="alamat"
                          class="border rounded-lg p-2 col-span-3"
                          placeholder="Alamat lengkap"></textarea>
            </div>

            <input id="search"
                   class="border rounded-lg p-2 w-full mb-3 text-sm"
                   placeholder="Cari lokasi">

            <div id="map"
                 class="w-full rounded-lg mb-4"
                 style="height:300px;"></div>

            <div class="flex justify-end gap-2">
                <button type="button"
                        onclick="closeModal()"
                        class="px-4 py-2 border rounded-lg text-sm">
                    Batal
                </button>
                <button
                    class="bg-blue-600 hover:bg-blue-700
                           text-white px-4 py-2 rounded-lg
                           text-sm transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- SCRIPT (TIDAK DIUBAH) --}}
<script>
let map, marker, circle

function openModal(){
    modalTempatPkl.classList.remove('hidden')
    modalTempatPkl.classList.add('flex')

    setTimeout(() => initMap(), 300)
}

function closeModal(){
    modalTempatPkl.classList.add('hidden')
    modalTempatPkl.classList.remove('flex')

    formBengkel.reset()
    formBengkel.action = "{{ route('admin.tempat-pkl.store') }}"
    methodBengkel.value = "POST"

    if (map) {
        map.remove()
        map = null
        marker = null
        circle = null
    }
}

function initMap(){
    if (map) return

    map = L.map('map').setView([-7.55, 112.22], 13)

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map)

    setTimeout(() => map.invalidateSize(), 200)

    map.on('click', e => {
        setMarker(e.latlng.lat, e.latlng.lng)
    })
}

function setMarker(lat, lng){
    latitude.value = lat
    longitude.value = lng

    if (marker) map.removeLayer(marker)
    if (circle) map.removeLayer(circle)

    marker = L.marker([lat, lng], { draggable: true }).addTo(map)

    let r = radius.value || 100

    circle = L.circle([lat, lng], {
        radius: r,
        color: 'blue',
        fillOpacity: 0.2
    }).addTo(map)

    marker.on('dragend', e => {
        let p = e.target.getLatLng()
        latitude.value = p.lat
        longitude.value = p.lng
        circle.setLatLng(p)
    })
}

function editBengkel(id){
    fetch(`/admin/tempat-pkl/${id}/edit`)
    .then(r => r.json())
    .then(d => {

        formBengkel.action = `/admin/tempat-pkl/${id}`
        methodBengkel.value = "PUT"

        for (let k in d) {
            let el = document.querySelector(`[name="${k}"]`)
            if (el) el.value = d[k]
        }

        openModal()

        setTimeout(() => {
            if (d.latitude && d.longitude) {
                map.setView([d.latitude, d.longitude], 16)
                setMarker(d.latitude, d.longitude)
            }
        }, 600)
    })
}
</script>

@endsection
