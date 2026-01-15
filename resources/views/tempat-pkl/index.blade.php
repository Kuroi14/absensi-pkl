@extends('layouts.app')

@section('content')
<div class="bg-white rounded-lg shadow p-6 mb-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold">Data Bengkel</h2>
        <button onclick="openModal()"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
            + Tambah Bengkel
        </button>
    </div>

    {{-- UPLOAD & DOWNLOAD --}}
    <div class="flex items-center gap-3 mb-4">
        <form action="{{ route('admin.tempat-pkl.import') }}"
              method="POST"
              enctype="multipart/form-data"
              class="flex items-center gap-2">
            @csrf
            <input type="file" name="file" required
                   class="border p-2 rounded h-10 text-sm">
            <button class="bg-blue-600 text-white px-4 h-10 rounded text-sm">
                Upload Excel
            </button>
        </form>

        <a href="{{ route('admin.tempat-pkl.template') }}"
           class="bg-green-600 text-white px-4 h-10 rounded text-sm
                  inline-flex items-center">
            Download Template
        </a>
    </div>

    {{-- TABLE --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="border-b text-gray-50">
                <tr>
                    <th class="py-3 text-left">Nama</th>
                    <th class="py-3 text-left">Pemilik Bengkel</th>
                    <th class="py-3 text-left">Telp</th>
                    <th class="py-3 text-left w-64">Alamat</th>
                    <th class="py-3 text-center w-32">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tempatPkls as $t)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-3">{{ $t->nama }}</td>
                    <td class="py-3">{{ $t->pembimbing }}</td>
                    <td class="py-3">{{ $t->telp }}</td>
                    <td class="py-3 max-w-xs">
                        <div class="truncate" title="{{ $t->alamat }}">
                            {{ $t->alamat }}
                        </div>
                    </td>
                    <td class="px-3 py-3">
                        <div class="flex justify-center gap-2">
                            <button onclick="editBengkel({{ $t->id }})"
                                class="bg-blue-500 text-white px-3 py-1 rounded text-xs">
                                Edit
                            </button>
                            <form method="POST"
                                  action="{{ route('admin.tempat-pkl.destroy',$t->id) }}"
                                  onsubmit="return confirm('Hapus bengkel ini?')">
                                @csrf
                                @method('DELETE')
                                <button
                                    class="bg-red-500 text-white px-3 py-1 rounded text-xs">
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

{{-- MODAL --}}
<div id="modalTempatPkl"
    class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white w-full max-w-2xl rounded shadow p-5 my-10">
        <h2 class="text-lg font-bold mb-4" id="modalTitle">Tambah Bengkel</h2>

        <form method="POST" id="formBengkel"
              action="{{ route('admin.tempat-pkl.store') }}">
            @csrf
            <input type="hidden" name="_method" id="methodBengkel" value="POST">

            <div class="grid grid-cols-2 gap-4 mb-4">
                <input name="nama" class="border p-2 rounded" placeholder="Nama Bengkel">
                <input name="pembimbing" class="border p-2 rounded" placeholder="Pemilik">
                <input name="telp" class="border p-2 rounded" placeholder="Telp">
                <input name="radius" id="radius" value="100"
                       class="border p-2 rounded" placeholder="Radius">
            </div>

            <textarea name="alamat"
                class="border p-2 rounded w-full mb-3"
                placeholder="Alamat lengkap"></textarea>

            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="longitude" id="longitude">

            <input id="search"
                   class="border p-2 rounded w-full mb-3"
                   placeholder="Cari lokasi">

            <div id="map" class="w-full rounded mb-4" style="height:300px;"></div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal()"
                    class="border px-4 py-2 rounded">
                    Batal
                </button>
                <button class="bg-blue-600 text-white px-4 py-2 rounded">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
<script>

let map, marker, circle

function openModal(){
    const modal = document.getElementById('modalTempatPkl')
    modal.classList.remove('hidden')
    modal.classList.add('flex')

    setTimeout(() => {
        initMap()
    }, 300)
}

function closeModal(){
    const modal = document.getElementById('modalTempatPkl')
    modal.classList.add('hidden')
    modal.classList.remove('flex')

    document.getElementById('formBengkel').reset()
    document.getElementById('formBengkel').action =
        "{{ route('admin.tempat-pkl.store') }}"
    document.getElementById('methodBengkel').value = "POST"

    // 🔥 HANCURKAN MAP TOTAL
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

    setTimeout(() => {
        map.invalidateSize()
    }, 200)

    map.on('click', function(e){
        setMarker(e.latlng.lat, e.latlng.lng)
    })
}

function setMarker(lat, lng){
    document.getElementById('latitude').value = lat
    document.getElementById('longitude').value = lng

    if (marker) map.removeLayer(marker)
    if (circle) map.removeLayer(circle)

    marker = L.marker([lat, lng], { draggable: true }).addTo(map)

    let radius = document.getElementById('radius').value || 100

    circle = L.circle([lat, lng], {
        radius: radius,
        color: 'blue',
        fillOpacity: 0.2
    }).addTo(map)

    marker.on('dragend', function(e){
        let pos = e.target.getLatLng()
        document.getElementById('latitude').value = pos.lat
        document.getElementById('longitude').value = pos.lng
        circle.setLatLng(pos)
    })
}

function editBengkel(id){
    fetch(`/admin/tempat-pkl/${id}/edit`)
    .then(res => res.json())
    .then(data => {

        const form = document.getElementById('formBengkel')
        form.action = `/admin/tempat-pkl/${id}`
        document.getElementById('methodBengkel').value = "PUT"

        for (let key in data) {
            let el = document.querySelector(`[name="${key}"]`)
            if (el) el.value = data[key]
        }

        openModal()

        setTimeout(() => {
            if (data.latitude && data.longitude) {
                map.setView([data.latitude, data.longitude], 16)
                setMarker(data.latitude, data.longitude)
            }
        }, 600)
    })
}
</script>

