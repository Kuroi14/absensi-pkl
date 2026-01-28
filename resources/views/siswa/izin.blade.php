@extends('layouts.app')

@section('content')
<div x-data="{ openModal: false }" class="max-w-5xl mx-auto space-y-6">

    {{-- HEADER --}}
    <div class="bg-white p-5 rounded shadow flex items-center gap-3">
        <span class="w-12 h-12 flex items-center justify-center rounded-lg bg-blue-100 text-blue-600">
            <span class="material-symbols-outlined text-3xl">
                assignment
            </span>
        </span>

        <div>
            <h2 class="text-xl font-bold">Pengajuan Izin</h2>
            <p class="text-sm text-gray-500">
                Ajukan izin sakit atau izin tidak masuk
            </p>
        </div>
    </div>

    {{-- BUTTON --}}
    <button
        @click="openModal = true"
        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        + Ajukan Izin
    </button>

    {{-- RIWAYAT IZIN --}}
    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full text-sm border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">Tanggal</th>
                    <th class="border px-4 py-2">Jenis</th>
                    <th class="border px-4 py-2">Keterangan</th>
                    <th class="border px-4 py-2">Status</th>
                    <th class="border px-4 py-2">Disetujui</th>
                </tr>
            </thead>

            <tbody>
            @forelse($izins as $izin)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2">
                        {{ \Carbon\Carbon::parse($izin->tanggal)->format('d-m-Y') }}
                    </td>

                    <td class="border px-4 py-2 capitalize">
                        {{ $izin->jenis }}
                    </td>

                    <td class="border px-4 py-2">
                        {{ $izin->keterangan ?? '-' }}
                    </td>

                    <td class="border px-4 py-2 text-center">
                        @if($izin->status === 'pending')
                            <span class="text-yellow-600 font-semibold">Menunggu</span>
                        @elseif($izin->status === 'disetujui')
                            <span class="text-green-600 font-semibold">Disetujui</span>
                        @else
                            <span class="text-red-600 font-semibold">Ditolak</span>
                        @endif
                    </td>

                    <td class="border px-4 py-2 text-center">
                        {{ $izin->approved_at
                            ? $izin->approved_at->format('d-m-Y H:i')
                            : '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-6 text-gray-500">
                        Belum ada riwayat izin
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- MODAL --}}
    <div x-show="openModal"
         x-cloak
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

        <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6"
             @click.outside="openModal = false">

            <h3 class="text-lg font-bold mb-4">
                Ajukan Izin
            </h3>

            <form method="POST" action="{{ route('izin.store') }}">
                @csrf

                {{-- TANGGAL --}}
                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Tanggal</label>
                    <input type="date" name="tanggal" required
                           class="w-full border rounded px-3 py-2">
                </div>

                {{-- JENIS --}}
                <div class="mb-3">
                    <label class="block text-sm font-medium mb-1">Jenis Izin</label>
                    <select name="jenis" required
                            class="w-full border rounded px-3 py-2">
                        <option value="">-- Pilih --</option>
                        <option value="sakit">Sakit</option>
                        <option value="izin">Izin</option>
                    </select>
                </div>

                {{-- KETERANGAN --}}
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Keterangan</label>
                    <textarea name="keterangan" rows="3"
                              class="w-full border rounded px-3 py-2"></textarea>
                </div>

                {{-- ACTION --}}
                <div class="flex justify-end gap-2">
                    <button type="button"
                            @click="openModal = false"
                            class="px-4 py-2 border rounded">
                        Batal
                    </button>

                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded">
                        Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
