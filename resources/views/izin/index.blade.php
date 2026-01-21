@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded shadow">

    <h2 class="text-xl font-semibold mb-4">
        Monitoring Izin Siswa
    </h2>

    <table class="w-full border">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3 border">Nama</th>
                <th class="p-3 border">Tanggal</th>
                <th class="p-3 border">Jenis</th>
                <th class="p-3 border">Keterangan</th>
                <th class="p-3 border">Status</th>
                <th class="p-3 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse($izins as $i)
            <tr>
                <td class="p-3 border">{{ $i->siswa->nama }}</td>
                <td class="p-3 border">{{ $i->tanggal }}</td>
                <td class="p-3 border">{{ ucfirst($i->jenis) }}</td>
                <td class="p-3 border">{{ $i->keterangan }}</td>
                <td class="p-3 border">{{ ucfirst($i->status) }}</td>
                <td class="p-3 border text-center">
                    @if($i->status == 'pending')
                        <form method="POST"
                              action="{{ route('admin.izin.approve',$i->id) }}"
                              class="inline">
                            @csrf @method('PUT')
                            <button class="bg-green-600 text-white px-3 py-1 rounded">
                                Setujui
                            </button>
                        </form>

                        <form method="POST"
                              action="{{ route('admin.izin.reject',$i->id) }}"
                              class="inline">
                            @csrf @method('PUT')
                            <button class="bg-red-600 text-white px-3 py-1 rounded">
                                Tolak
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="p-4 text-center text-gray-500">
                    Belum ada pengajuan izin
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
