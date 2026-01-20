@extends('layouts.app')

@section('content')

<div class="bg-white rounded-lg shadow p-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Data Siswa</h2>

        <button onclick="openModal()"
            class="bg-blue-600 text-white px-4 py-2 rounded">
            + Tambah Siswa
        </button>
    </div>
{{-- UPLOAD & DOWNLOAD --}}
<div class="flex items-center gap-3 mb-4">
    <form action="{{ route('admin.siswa.import') }}"
          method="POST"
          enctype="multipart/form-data"
          class="flex items-center gap-2">
        @csrf

        <input type="file"
               name="file"
               required
               class="border p-2 rounded text-sm">

        <button
            class="bg-blue-600 hover:bg-blue-700 text-white
                   px-4 py-2 rounded text-sm">
            Upload Excel
        </button>
    </form>

    <a href="{{ route('admin.siswa.template') }}"
       class="bg-green-600 hover:bg-green-700 text-white
              px-4 py-2 rounded text-sm">
        Download Template
    </a>
</div>

    {{-- FLASH --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="overflow-x-auto">
        <table class="w-full border-collapse">
            <thead>
                <tr class="border-b text-gray-600 bg-gray-50">
                    <th class="p-3 text-left">NIS</th>
                    <th class="p-3 text-left">Nama</th>
                    <th class="p-3 text-left">Kelas</th>
                    <th class="p-3 text-left">Guru</th>
                    <th class="p-3 text-left">Tempat PKL</th>
                    <th class="p-3 text-left">Aksi</th>
                </tr>
            </thead>

            <tbody>
            @foreach($siswas as $s)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">{{ $s->nis }}</td>
                    <td class="p-3">{{ $s->nama }}</td>
                    <td class="p-3">{{ $s->kelas }}</td>
                    <td class="p-3">{{ $s->guru?->nama }}</td>
                    <td class="p-3">{{ $s->tempatPkl?->nama }}</td>
                    <td class="p-3 space-x-2">

                        <button onclick="editSiswa({{ $s->id }})"
                            class="bg-blue-500 text-white px-3 py-1 rounded text-sm">
                            Edit
                        </button>

                        <form method="POST"
                              action="{{ route('admin.siswa.destroy',$s->id) }}"
                              class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 text-white px-3 py-1 rounded text-sm">
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

{{-- MODAL --}}
<div id="modalSiswa"
     class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">

    <div class="bg-white w-full max-w-4xl rounded shadow p-6">
        <h2 class="text-lg font-bold mb-4" id="modalTitle">Tambah Siswa</h2>

        <form method="POST" id="formSiswa" action="{{ route('admin.siswa.store') }}">
            @csrf
            <input type="hidden" name="_method" id="methodSiswa" value="POST">

            <div class="grid grid-cols-3 gap-3">

                <input name="nis" placeholder="NIS" class="border p-2 rounded">
                <input name="nama" placeholder="Nama" class="border p-2 rounded">
                <input name="kelas" placeholder="Kelas" class="border p-2 rounded">

                <input name="username" placeholder="Username" class="border p-2 rounded">
                <input name="password" placeholder="Password" class="border p-2 rounded">

                <select name="guru_id" class="border p-2 rounded">
                    <option value="">Guru Pembimbing</option>
                    @foreach($gurus as $g)
                        <option value="{{ $g->id }}">{{ $g->nama }}</option>
                    @endforeach
                </select>

                <select name="tempat_pkl_id" class="border p-2 rounded">
                    <option value="">Tempat PKL</option>
                    @foreach($tempatPkls as $t)
                        <option value="{{ $t->id }}">{{ $t->nama }}</option>
                    @endforeach
                </select>

                <input name="tempat_lahir" placeholder="Tempat Lahir" class="border p-2 rounded">
                <input type="date" name="tanggal_lahir" class="border p-2 rounded">

                <select name="jenis_kelamin" class="border p-2 rounded">
                    <option value="">Jenis Kelamin</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>

                <input name="no_hp" placeholder="No HP Siswa" class="border p-2 rounded">
                <input name="no_hp_ortu" placeholder="No HP Orang Tua" class="border p-2 rounded">

                <textarea name="alamat"
                          class="border p-2 rounded col-span-3"
                          placeholder="Alamat"></textarea>
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button"
                        onclick="closeModal()"
                        class="px-4 py-2 border rounded">
                    Batal
                </button>

                <button class="bg-blue-600 text-white px-4 py-2 rounded">
                    Simpan
                </button>
            </div>

        </form>
    </div>
</div>

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
    <ul>
        @foreach(session('import_errors') as $err)
            <li>{{ $err }}</li>
        @endforeach
    </ul>
@endif
