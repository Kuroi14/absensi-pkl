@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Rekap Bulanan Absensi PKL</h1>

<form method="GET" class="flex gap-3 mb-4">
    <select name="bulan" class="border p-2">
        @for($i=1;$i<=12;$i++)
            <option value="{{ $i }}" {{ $bulan==$i?'selected':'' }}>
                {{ date('F', mktime(0,0,0,$i,1)) }}
            </option>
        @endfor
    </select>

    <select name="tahun" class="border p-2">
        @for($y=date('Y')-2;$y<=date('Y');$y++)
            <option value="{{ $y }}" {{ $tahun==$y?'selected':'' }}>
                {{ $y }}
            </option>
        @endfor
    </select>

    <button class="bg-blue-600 text-white px-4 rounded">
        Tampilkan
    </button>
</form>

<a href="/rekap/bulanan/excel?bulan={{ $bulan }}"
   class="bg-green-600 text-white px-4 py-2 rounded inline-block">
   Export Excel
</a>

<table class="w-full bg-white shadow rounded">
<thead class="bg-gray-200">
<tr>
    <th class="p-2">NIS</th>
    <th class="p-2">Nama</th>
    <th class="p-2">Kelas</th>
    <th class="p-2">Tempat PKL</th>
    <th class="p-2">Hadir</th>
</tr>
</thead>
<tbody>
@forelse($rekap as $r)
<tr class="border-t">
    <td class="p-2">{{ $r->nis }}</td>
    <td class="p-2">{{ $r->nama }}</td>
    <td class="p-2">{{ $r->kelas }}</td>
    <td class="p-2">{{ $r->tempat_pkl }}</td>
    <td class="p-2 text-center">{{ $r->hadir }}</td>
</tr>
@empty
<tr>
    <td colspan="5" class="p-4 text-center text-gray-500">
        Data tidak ditemukan
    </td>
</tr>
@endforelse
</tbody>
</table>
@endsection
