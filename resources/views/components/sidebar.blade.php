<div
    class="bg-blue-800 text-white transition-all duration-300"
    :class="sidebarOpen ? 'w-64' : 'w-16'"
>

    <div class="p-4 font-bold text-lg text-center">
        <span x-show="sidebarOpen">ABSENSI PKL</span>
        <span x-show="!sidebarOpen">AP</span>
    </div>

    <nav class="px-2 space-y-1">

        @if(auth()->user()->role === 'admin')

            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-blue-700">
                Dashboard
            </a>

            <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 hover:bg-blue-700">
                Manajemen User
            </a>

            <a href="{{ route('admin.guru.index') }}" class="block px-4 py-2 hover:bg-blue-700">
                Master Guru
            </a>

            <a href="{{ route('admin.siswa.index') }}" class="block px-4 py-2 hover:bg-blue-700">
                Master Siswa
            </a>

            <a href="{{ route('admin.tempat-pkl.index') }}" class="block px-4 py-2 hover:bg-blue-700">
                Master Bengkel
            </a>

            <a href="{{ route('admin.rekap') }}" class="block px-4 py-2 hover:bg-blue-700">
                Rekap Absensi
            </a>

        @endif
@if(auth()->user()->role=='guru')
<nav class="space-y-1">

<a href="{{ route('guru.dashboard') }}" class="block px-4 py-2 hover:bg-blue-700">
Dashboard Guru
</a>

<a href="{{ route('guru.absensi') }}" class="block px-4 py-2 hover:bg-blue-700">
Monitoring Absen
</a>

<a href="{{ route('guru.izin') }}" class="block px-4 py-2 hover:bg-blue-700">
Persetujuan Izin
</a>

<a href="{{ route('guru.koreksi') }}" class="block px-4 py-2 hover:bg-blue-700">
Koreksi Absen
</a>

<a href="{{ route('guru.laporan') }}" class="block px-4 py-2 hover:bg-blue-700">
Laporan Kehadiran
</a>

</nav>
@endif
    </nav>
</div>



