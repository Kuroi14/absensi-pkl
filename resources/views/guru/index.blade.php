@extends('layouts.app')

@section('content')
<div class="space-y-6">

    {{-- =======================
        HEADER
    ======================= --}}
    <div class="bg-white p-5 rounded-xl shadow flex items-center justify-between">
        <div class="flex items-center gap-4">
            <span class="w-12 h-12 flex items-center justify-center
                         rounded-lg bg-blue-100 text-blue-600">
                <span class="material-symbols-outlined text-3xl">
                    school
                </span>
            </span>

            <div>
                <h2 class="text-xl font-bold text-gray-800">
                    Data Guru
                </h2>
                <p class="text-sm text-gray-500">
                    Kelola data guru dan akun login
                </p>
            </div>
        </div>

        <button onclick="openModal()"
            class="bg-blue-600 hover:bg-blue-700
                   text-white px-5 py-2 rounded-lg
                   text-sm font-semibold transition">
            + Tambah Guru
        </button>
    </div>

    {{-- =======================
        UPLOAD & DOWNLOAD
    ======================= --}}
    <div class="bg-white rounded-xl shadow p-4 flex flex-wrap items-center gap-3">
        <form action="{{ route('admin.guru.import') }}"
              method="POST"
              enctype="multipart/form-data"
              class="flex items-center gap-2">
            @csrf

            <input type="file"
                   name="file"
                   required
                   class="border rounded-lg p-2 text-sm">

            <button
                class="bg-blue-600 hover:bg-blue-700
                       text-white px-4 py-2 rounded-lg
                       text-sm transition">
                Upload Excel
            </button>
        </form>

        <a href="{{ route('admin.guru.template') }}"
           class="bg-green-600 hover:bg-green-700
                  text-white px-4 py-2 rounded-lg
                  text-sm transition">
            Download Template
        </a>
    </div>

    {{-- =======================
        TABLE
    ======================= --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="border px-4 py-3 text-left">NIP</th>
                        <th class="border px-4 py-3 text-left">Nama Guru</th>
                        <th class="border px-4 py-3 text-left">Mapel</th>
                        <th class="border px-4 py-3 text-left">Jenis Ketenagaan</th>
                        <th class="border px-4 py-3 text-left">No. Telepon</th>
                        <th class="border px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($gurus as $g)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="border px-4 py-2">{{ $g->nip ?? '-' }}</td>
                        <td class="border px-4 py-2 font-medium">{{ $g->nama }}</td>
                        <td class="border px-4 py-2">{{ $g->mapel ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $g->jenis_ketenagaan ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $g->no_hp ?? '-' }}</td>
                        <td class="border px-4 py-2 text-center">
                            <div class="flex justify-center gap-2">
                                <button onclick="editGuru({{ $g->id }})"
                                    class="bg-blue-500 hover:bg-blue-600
                                           text-white px-3 py-1 rounded
                                           text-xs transition">
                                    Edit
                                </button>

                                <form method="POST"
                                      action="{{ route('admin.guru.destroy',$g->id) }}"
                                      onsubmit="return confirm('Hapus guru ini?')">
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

{{-- =======================
    MODAL GURU
======================= --}}
<div id="modalGuru"
     class="fixed inset-0 bg-black bg-opacity-50 hidden
            items-center justify-center z-50">
    <div class="bg-white w-full max-w-xl rounded-xl shadow p-6">
        <h2 class="text-lg font-bold mb-4 text-gray-700" id="titleGuru">
            Tambah Guru
        </h2>

        <form id="formGuru" method="POST"
              action="{{ route('admin.guru.store') }}">
            @csrf
            <input type="hidden" name="_method" id="methodGuru" value="POST">

            <div class="grid grid-cols-2 gap-3 text-sm">
                <input name="nip" placeholder="NIP" class="border rounded-lg p-2">
                <input name="nama" placeholder="Nama Guru"
                       class="border rounded-lg p-2" required>

                <input name="username" placeholder="Username Login"
                       class="border rounded-lg p-2">
                <input name="password" placeholder="Password Login"
                       class="border rounded-lg p-2">

                <input name="mapel" placeholder="Mapel"
                       class="border rounded-lg p-2">
                <input name="no_hp" placeholder="No HP"
                       class="border rounded-lg p-2">

                <select name="jenis_ketenagaan"
                        class="border rounded-lg p-2">
                    <option value="">-- Jenis Ketenagaan --</option>
                    <option value="Guru Produktif">Guru Produktif</option>
                    <option value="Guru Normatif">Guru Normatif</option>
                    <option value="Guru Adaptif">Guru Adaptif</option>
                    <option value="Tenaga Kependidikan">Tenaga Kependidikan</option>
                </select>

                <textarea name="alamat"
                          class="border rounded-lg p-2 col-span-2"
                          placeholder="Alamat"></textarea>
            </div>

            <div class="flex justify-end gap-2 mt-5">
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

{{-- =======================
    SCRIPT (TIDAK DIUBAH)
======================= --}}
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

function editGuru(id) {
    fetch('/admin/guru/' + id + '/edit')
        .then(res => res.json())
        .then(g => {
            openModal()

            document.getElementById('titleGuru').innerText = 'Edit Guru'

            const form = document.getElementById('formGuru')
            form.action = '/admin/guru/' + id
            document.getElementById('methodGuru').value = 'PUT'

            form.nip.value = g.nip ?? ''
            form.nama.value = g.nama
            form.mapel.value = g.mapel ?? ''
            form.no_hp.value = g.no_hp ?? ''
            form.jenis_ketenagaan.value = g.jenis_ketenagaan ?? ''
            form.alamat.value = g.alamat ?? ''
            form.username.value = g.user.username
            form.password.value = ''
        })
}
</script>

@if(session('error'))
<div class="bg-red-100 text-red-700 p-3 rounded mt-4">
    {{ session('error') }}
</div>
@endif

@endsection
