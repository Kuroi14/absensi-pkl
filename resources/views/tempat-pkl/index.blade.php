@extends('layouts.app')

@section('content')
<h1 class="text-xl font-bold mb-4">Master Tempat PKL</h1>

<a href="{{ route('tempat-pkl.create') }}"
   class="bg-blue-600 text-white px-4 py-2 rounded">
   Tambah Tempat PKL
</a>

<table class="w-full mt-4 border">
<thead>
<tr class="bg-gray-200">
    <th class="p-2">Nama</th>
    <th class="p-2">Alamat</th>
    <th class="p-2">Radius</th>
    <th class="p-2">Aksi</th>
</tr>
</thead>
<tbody>
@foreach($data as $t)
<tr class="border-t">
    <td class="p-2">{{ $t->nama }}</td>
    <td class="p-2">{{ $t->alamat }}</td>
    <td class="p-2">{{ $t->radius }} m</td>
    <td class="p-2">
        <a href="{{ route('tempat-pkl.edit',$t->id) }}"
           class="text-blue-600">Edit</a>
    </td>
</tr>
@endforeach
</tbody>
</table>
@endsection
