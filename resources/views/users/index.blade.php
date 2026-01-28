@extends('layouts.app')

@section('content')
<div class="space-y-6 max-w-6xl mx-auto">

    {{-- =======================
        HEADER
    ======================= --}}
    <div class="bg-white p-5 rounded-xl shadow flex items-center gap-4">
        <span class="w-12 h-12 flex items-center justify-center
                     rounded-lg bg-indigo-100 text-indigo-600">
            <span class="material-symbols-outlined text-3xl">
                manage_accounts
            </span>
        </span>

        <div>
            <h2 class="text-xl font-bold text-gray-800">
                Manajemen Pengguna
            </h2>
            <p class="text-sm text-gray-500">
                Tambah dan kelola akun admin, guru, dan siswa
            </p>
        </div>
    </div>

    {{-- =======================
        FORM TAMBAH USER
    ======================= --}}
    <div class="bg-white rounded-xl shadow p-5">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">
            Tambah Pengguna
        </h3>

        <form method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            @csrf

            <input
                name="nama"
                placeholder="Nama Lengkap"
                class="border rounded-lg px-3 py-2 text-sm
                       focus:ring-2 focus:ring-blue-200 focus:outline-none"
                required
            >

            <input
                name="username"
                placeholder="Username"
                class="border rounded-lg px-3 py-2 text-sm
                       focus:ring-2 focus:ring-blue-200 focus:outline-none"
                required
            >

            <input
                type="password"
                name="password"
                placeholder="Password"
                class="border rounded-lg px-3 py-2 text-sm
                       focus:ring-2 focus:ring-blue-200 focus:outline-none"
                required
            >

            <select
                name="role"
                class="border rounded-lg px-3 py-2 text-sm
                       focus:ring-2 focus:ring-blue-200 focus:outline-none"
                required
            >
                <option value="">Pilih Role</option>
                <option value="admin">Admin</option>
                <option value="guru">Guru</option>
                <option value="siswa">Siswa</option>
            </select>

            <div class="md:col-span-4 flex justify-end">
                <button
                    class="bg-blue-600 hover:bg-blue-700
                           text-white px-6 py-2 rounded-lg
                           font-semibold transition shadow">
                    Simpan
                </button>
            </div>
        </form>
    </div>

    {{-- =======================
        TABEL USER
    ======================= --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="border px-4 py-3 text-left">No</th>
                        <th class="border px-4 py-3 text-left">Nama</th>
                        <th class="border px-4 py-3 text-left">Username</th>
                        <th class="border px-4 py-3 text-center">Role</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($users as $u)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="border px-4 py-2">
                            {{ $loop->iteration }}
                        </td>

                        <td class="border px-4 py-2 font-medium">
                            {{ $u->nama }}
                        </td>

                        <td class="border px-4 py-2 text-gray-600">
                            {{ $u->username }}
                        </td>

                        <td class="border px-4 py-2 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($u->role == 'admin')
                                    bg-red-100 text-red-700
                                @elseif($u->role == 'guru')
                                    bg-blue-100 text-blue-700
                                @else
                                    bg-green-100 text-green-700
                                @endif">
                                {{ ucfirst($u->role) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4"
                            class="text-center py-6 text-gray-500">
                            Belum ada data pengguna
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
