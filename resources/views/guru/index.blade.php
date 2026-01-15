@extends('layouts.app')

@section('content')

<div class="bg-white rounded-lg shadow p-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold">Data Guru</h2>

        <button onclick="openModal()"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
            + Tambah Guru
        </button>
    </div>

    {{-- UPLOAD EXCEL --}}
    <div class="flex gap-3 mb-4">
    <form action="{{ route('admin.guru.import') }}"
          method="POST"
          enctype="multipart/form-data"
          class="flex gap-2">
        @csrf
        <input type="file" name="file" required class="border p-2 rounded">
        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Upload Excel
        </button>
    </form>
    <a href="{{ route('admin.guru.template') }}"
       class="bg-green-600 text-white px-4 py-2 rounded">
        Download Template
    </a>
</div>


    {{-- TABLE --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="border-b text-gray-500">
                <tr>
                    <th class="text-left py-2">NIP</th>
                    <th class="text-left py-2">Nama Guru</th>
                    <th class="text-left py-2">Mapel</th>
                    <th class="text-left py-2">Jenis Ketenagaan</th>
                    <th class="text-left py-2">No. Telepon</th>
                    <th class="text-left py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($gurus as $g)
                <tr class="border-b">
                    <td class="py-2">{{ $g->nip ?? '-' }}</td>
                    <td class="py-2">{{ $g->nama }}</td>
                    <td class="py-2">{{ $g->mapel ?? '-' }}</td>
                    <td class="py-2">{{ $g->jenis_ketenagaan ?? '-' }}</td>
                    <td class="py-2">{{ $g->no_hp ?? '-' }}</td>
                    <td class="py-2 flex gap-2">
                        <button onclick="editGuru({{ $g->id }})"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs">
                            Edit
                        </button>

                        <form method="POST"
                              action="{{ route('admin.guru.destroy',$g->id) }}"
                              onsubmit="return confirm('Hapus guru ini?')">
                            @csrf
                            @method('DELETE')
                            <button
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- ================= MODAL ================= --}}
<div id="modalGuru" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-xl rounded shadow p-6">
        <h2 class="text-lg font-bold mb-4" id="titleGuru">Tambah Guru</h2>

        <form id="formGuru" method="POST" action="{{ route('admin.guru.store') }}">
            @csrf
            <input type="hidden" name="_method" id="methodGuru" value="POST">

            <div class="grid grid-cols-2 gap-3">
                <input name="nip" placeholder="NIP" class="border p-2 rounded">
                <input name="nama" placeholder="Nama Guru" class="border p-2 rounded" required>

                <input name="username" placeholder="Username Login" class="border p-2 rounded">
                <input name="password" placeholder="Password Login" class="border p-2 rounded">

                <input name="mapel" placeholder="Mapel" class="border p-2 rounded">
                <input name="no_hp" placeholder="No HP" class="border p-2 rounded">

                <select name="jenis_ketenagaan" class="border p-2 rounded">
                    <option value="">-- Jenis Ketenagaan --</option>
                    <option value="Guru Produktif">Guru Produktif</option>
                    <option value="Guru Normatif">Guru Normatif</option>
                    <option value="Guru Adaptif">Guru Adaptif</option>
                    <option value="Tenaga Kependidikan">Tenaga Kependidikan</option>
                </select>

                <textarea name="alamat" class="border p-2 rounded col-span-2" placeholder="Alamat"></textarea>
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeModal()" class="px-4 py-2 border rounded">
                    Batal
                </button>
                <button class="bg-blue-600 text-white px-4 py-2 rounded">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ================= SCRIPT ================= --}}
<script>
function openModal() {
    const modal = document.getElementById('modalGuru')
    modal.classList.remove('hidden')
    modal.classList.add('flex')
}

function closeModal() {
    const modal = document.getElementById('modalGuru')
    modal.classList.add('hidden')
    modal.classList.remove('flex')

    document.getElementById('formGuru').reset()
    document.getElementById('formGuru').action = "{{ route('admin.guru.store') }}"
    document.getElementById('methodGuru').value = "POST"
    document.getElementById('titleGuru').innerText = "Tambah Guru"
}
</script>
<script>
function editGuru(id) {
    fetch('/admin/guru/' + id + '/edit')
        .then(res => res.json())
        .then(g => {
            openModal()

            document.getElementById('titleGuru').innerText = 'Edit Guru'

            const form = document.getElementById('formGuru')

            // Ubah action ke UPDATE
            form.action = '/admin/guru/' + id
            document.getElementById('methodGuru').value = 'PUT'

            // Isi data ke form
            form.nip.value = g.nip ?? ''
            form.nama.value = g.nama
            form.mapel.value = g.mapel ?? ''
            form.no_hp.value = g.no_hp ?? ''
            form.jenis_ketenagaan.value = g.jenis_ketenagaan ?? ''
            form.alamat.value = g.alamat ?? ''

            form.username.value = g.user.username
            form.password.value = '' // kosongkan password
        })
}
</script>

@if(session('error'))
<div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
    {{ session('error') }}
</div>
@endif

@endsection
