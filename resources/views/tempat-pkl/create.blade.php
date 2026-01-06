@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">

    <h1 class="text-2xl font-bold mb-6">Tambah Tempat PKL</h1>

    <form action="{{ route('tempat-pkl.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block font-semibold mb-1">Nama Tempat PKL</label>
            <input type="text" name="nama" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block font-semibold mb-1">Alamat</label>
            <textarea name="alamat" class="w-full border p-2 rounded" required></textarea>
        </div>

        <div>
            <label class="block font-semibold mb-1">Pembimbing Industri</label>
            <input type="text" name="pembimbing" class="w-full border p-2 rounded">
        </div>

        <div>
            <label class="block font-semibold mb-1">No. Telepon</label>
            <input type="text" name="telp" class="w-full border p-2 rounded">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold mb-1">Latitude</label>
                <input type="text" name="latitude" class="w-full border p-2 rounded" required>
            </div>
            <div>
                <label class="block font-semibold mb-1">Longitude</label>
                <input type="text" name="longitude" class="w-full border p-2 rounded" required>
            </div>
        </div>

        <div>
            <label class="block font-semibold mb-1">Radius Absensi (meter)</label>
            <input type="number" name="radius" class="w-full border p-2 rounded" value="100" required>
        </div>

        <div class="flex gap-3 pt-4">
            <button class="bg-blue-600 text-white px-6 py-2 rounded">
                Simpan
            </button>
            <a href="/tempat-pkl" class="bg-gray-300 px-6 py-2 rounded">
                Batal
            </a>
        </div>

    </form>
</div>
@endsection
