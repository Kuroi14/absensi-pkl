@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Monitoring Izin Siswa</h2>

<div class="bg-white p-4 rounded shadow">
    <form method="GET" class="mb-4 flex gap-3">
        <select name="bulan" class="border p-2 rounded">
            <option value="">-- Pilih Bulan --</option>
            @for($m=1; $m<=12; $m++)
                <option value="{{ sprintf('%02d', $m) }}" {{ request('bulan') == sprintf('%02d', $m) ? 'selected' : '' }}>
                    {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                </option>
            @endfor
        </select>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filter</button>
    </form>
    <div class="white rounded shadow overflow-x-auto"></div>
    <table class="min-w-full border text-sm">
        <thead class="border-b text-gray-500">
            <tr>
                <th class="border px-3 py-2">Siswa</th>
                <th class="border px-3 py-2">Tanggal</th>
                <th class="border px-3 py-2">Jenis</th>
                <th class="border px-3 py-2">Keterangan</th>
                <th class="border px-3 py-2">Status</th>
                <th class="border px-3 py-2">Aksi</th>
</tr>
</thead>
<tbody>
@foreach($izins as $izin)
<tr class="border-b">
    <td class="py-2">{{ $izin->siswa->nama }}</td>
    <td class="py-2">{{ $izin->tanggal }}</td>
    <td class="py-2">{{ $izin->jenis }}</td>
    <td class="py-2">{{ $izin->keterangan }}</td>
    <td class="py-2">{{ $izin->status }}</td>
    <td class="py-2">
        @if($izin->status === 'pending')
        <form method="POST" action="{{ route('guru.izin.approve',$izin->id) }}">
            @csrf
            <button>Approve</button>
        </form>
        <form method="POST" action="{{ route('guru.izin.reject',$izin->id) }}">
            @csrf
            <button>Reject</button>
        </form>
        @endif
    </td>
</tr>
@endforeach
</tbody>
</table>
@endsection
