@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Ajukan Koreksi Absensi</h2>

    {{-- Info absensi --}}
    <div class="mb-4 p-4 bg-gray-100 rounded">
        <p><strong>Tanggal:</strong> {{ $absensi->tanggal }}</p>
        <p><strong>Check In:</strong> {{ $absensi->check_in_time ?? '-' }}</p>
        <p><strong>Check Out:</strong> {{ $absensi->check_out_time ?? '-' }}</p>
        <p><strong>Status:</strong> {{ $absensi->status }}</p>
    </div>

    {{-- Error --}}
    @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('siswa.koreksi-absensi.store', $absensi->id) }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf

        {{-- Jenis Koreksi --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Jenis Koreksi</label>
            <select name="jenis_koreksi" class="w-full border rounded p-2" required>
                <option value="">-- Pilih --</option>
                <option value="jam_masuk">Jam Masuk</option>
                <option value="jam_pulang">Jam Pulang</option>
                <option value="keduanya">Jam Masuk & Pulang</option>
            </select>
        </div>

        {{-- Alasan --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">Alasan Koreksi</label>
            <textarea name="alasan"
                      rows="4"
                      class="w-full border rounded p-2"
                      placeholder="Jelaskan alasan koreksi absensi"
                      required></textarea>
        </div>

        {{-- Bukti --}}
        <div class="mb-4">
            <label class="block font-semibold mb-1">
                Bukti Pendukung (opsional)
            </label>
            <input type="file"
                   name="bukti"
                   class="w-full border rounded p-2"
                   accept="image/*,application/pdf">
            <small class="text-gray-500">Foto atau PDF</small>
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end gap-2">
            <a href="{{ route('siswa.monitoring') }}"
               class="px-4 py-2 bg-gray-400 text-white rounded">
                Batal
            </a>

            <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded">
                Ajukan Koreksi
            </button>
        </div>
    </form>
</div>
@endsection
