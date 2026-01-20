@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white rounded-lg shadow p-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-700">Manajemen Pengguna</h2>
    </div>

    {{-- FORM TAMBAH USER --}}
    <div class="bg-gray-50 border rounded-lg p-5 mb-8">
        <h3 class="text-lg font-medium text-gray-600 mb-4">
            Tambah Pengguna
        </h3>

        <form method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            @csrf

            <input
                name="nama"
                placeholder="Nama Lengkap"
                class="border rounded px-3 py-2 focus:ring focus:ring-blue-200"
                required
            >

            <input
                name="username"
                placeholder="Username"
                class="border rounded px-3 py-2 focus:ring focus:ring-blue-200"
                required
            >

            <input
                type="password"
                name="password"
                placeholder="Password"
                class="border rounded px-3 py-2 focus:ring focus:ring-blue-200"
                required
            >

            <select
                name="role"
                class="border rounded px-3 py-2 focus:ring focus:ring-blue-200"
                required
            >
                <option value="">Pilih Role</option>
                <option value="admin">Admin</option>
                <option value="guru">Guru</option>
                <option value="siswa">Siswa</option>
            </select>

            <div class="md:col-span-4 flex justify-end">
                <button
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow"
                >
                    Simpan
                </button>
            </div>
        </form>
    </div>

    {{-- TABEL USER --}}
    <div class="overflow-x-auto">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-600 border-b">
                    <th class="p-3 text-left">No</th>
                    <th class="p-3 text-left">Nama</th>
                    <th class="p-3 text-left">Username</th>
                    <th class="p-3 text-left">Role</th>
                </tr>
            </thead>

            <tbody>
                @forelse($users as $u)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3">{{ $loop->iteration }}</td>
                        <td class="p-3">{{ $u->nama }}</td>
                        <td class="p-3">{{ $u->username }}</td>
                        <td class="p-3 capitalize">
                            <span class="px-2 py-1 rounded text-sm
                                @if($u->role == 'admin') bg-red-100 text-red-700
                                @elseif($u->role == 'guru') bg-blue-100 text-blue-700
                                @else bg-green-100 text-green-700
                                @endif">
                                {{ $u->role }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center text-gray-500">
                            Belum ada data pengguna
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
