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
                    groups
                </span>
            </span>

            <div>
                <h2 class="text-xl font-bold text-gray-800">
                    Data Siswa
                </h2>
                <p class="text-sm text-gray-500">
                    Kelola data siswa dan akun login
                </p>
            </div>
        </div>

        <button onclick="openModal()"
            class="bg-blue-600 hover:bg-blue-700
                   text-white px-5 py-2 rounded-lg
                   text-sm font-semibold transition">
            + Tambah Siswa
        </button>
    </div>

    {{-- =======================
        UPLOAD & DOWNLOAD
    ======================= --}}
    <div class="bg-white rounded-xl shadow p-4 flex flex-wrap items-center gap-3">
        <form action="{{ route('admin.siswa.import') }}"
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

        <a href="{{ route('admin.siswa.template') }}"
           class="bg-green-600 hover:bg-green-700
                  text-white px-4 py-2 rounded-lg
                  text-sm transition">
            Download Template
        </a>
    </div>

    {{-- =======================
        FLASH
    ======================= --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- =======================
        TABLE
    ======================= --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="border px-4 py-3 text-left">NIS</th>
                        <th class="border px-4 py-3 text-left">Nama</th>
                        <th class="border px-4 py-3 text-left">Kelas</th>
                        <th class="border px-4 py-3 text-left">Guru</th>
                        <th class="border px-4 py-3 text-left">Tempat PKL</th>
                        <th class="border px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($siswas as $s)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="border px-4 py-2">{{ $s->nis }}</td>
                        <td class="border px-4 py-2 font-medium">{{ $s->nama }}</td>
                        <td class="border px-4 py-2">{{ $s->kelas }}</td>
                        <td class="border px-4 py-2">
                            {{ $s->guru?->nama ?? '-' }}
                        </td>
                        <td class="border px-4 py-2">
                            {{ $s->tempatPkl?->nama ?? '-' }}
                        </td>
                        <td class="border px-4 py-2 text-center">
                            <div class="flex justify-center gap-2">
                                <button onclick="editSiswa({{ $s->id }})"
                                    class="bg-blue-500 hover:bg-blue-600
                                           text-white px-3 py-1 rounded
                                           text-xs transition">
                                    Edit
                                </button>

                                <form method="POST"
                                      action="{{ route('admin.siswa.destroy',$s->id) }}"
                                      onsubmit="return confirm('Hapus data siswa ini?')">
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
    MODAL SISWA
======================= --}}
<div id="modalSiswa"
     class="fixed inset-0 bg-black bg-opacity-50 hidden
            items-center justify-center z-50">

    <div class="bg-white w-full max-w-5xl rounded-xl shadow p-6">
        <h2 class="text-lg font-bold mb-4 text-gray-700" id="modalTitle">
            Tambah Siswa
        </h2>

        <form method="POST" id="formSiswa"
              action="{{ route('admin.siswa.store') }}">
            @csrf
            <input type="hidden" name="_method" id="methodSiswa" value="POST">

            <div class="grid grid-cols-3 gap-3 text-sm">

                <input name="nis" placeholder="NIS" class="border rounded-lg p-2">
                <input name="nama" placeholder="Nama Siswa" class="border rounded-lg p-2">
                <input name="kelas" placeholder="Kelas" class="border rounded-lg p-2">

                <input name="username" placeholder="Username Login" class="border rounded-lg p-2">
                <input name="password" placeholder="Password Login" class="border rounded-lg p-2">

                <select name="guru_id" class="border rounded-lg p-2">
                    <option value="">Guru Pembimbing</option>
                    @foreach($gurus as $g)
                        <option value="{{ $g->id }}">{{ $g->nama }}</option>
                    @endforeach
                </select>

                <select name="tempat_pkl_id" class="border rounded-lg p-2">
                    <option value="">Tempat PKL</option>
                    @foreach($tempatPkls as $t)
                        <option value="{{ $t->id }}">{{ $t->nama }}</option>
                    @endforeach
                </select>

                <input name="tempat_lahir" placeholder="Tempat Lahir" class="border rounded-lg p-2">
                <input type="date" name="tanggal_lahir" class="border rounded-lg p-2">

                <select name="jenis_kelamin" class="border rounded-lg p-2">
                    <option value="">Jenis Kelamin</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>

                <input name="no_telp_siswa" placeholder="No HP Siswa" class="border rounded-lg p-2">
                <input name="no_telp_ortu" placeholder="No HP Orang Tua" class="border rounded-lg p-2">

                <textarea name="alamat"
                          class="border rounded-lg p-2 col-span-3"
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
function openModal(){
    modalSiswa.classList.remove('hidden')
    modalSiswa.classList.add('flex')
}

function closeModal(){
    modalSiswa.classList.add('hidden')
    modalSiswa.classList.remove('flex')
    formSiswa.reset()
    formSiswa.action = "{{ route('admin.siswa.store') }}"
    methodSiswa.value = "POST"
}

function editSiswa(id){
    fetch(`/admin/siswa/${id}/edit`)
    .then(r => r.json())
    .then(d => {
        formSiswa.action = `/admin/siswa/${id}`
        methodSiswa.value = "PUT"

        for(let k in d){
            let el = document.querySelector(`[name="${k}"]`)
            if(el) el.value = d[k]
        }

        openModal()
    })
}
</script>

@endsection

@if(session('import_errors'))
<div class="bg-red-100 text-red-700 p-4 rounded mt-4">
    <ul>
        @foreach(session('import_errors') as $err)
            <li>- {{ $err }}</li>
        @endforeach
    </ul>
</div>
@endif
