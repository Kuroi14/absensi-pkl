<div
    x-data="{ sidebarOpen: true }"
    class="bg-blue-800 text-white h-screen transition-all duration-300 flex flex-col"
    :class="sidebarOpen ? 'w-64' : 'w-16'"
>

    {{-- HEADER --}}
    <div class="flex items-center justify-between p-4">
        <span class="font-bold text-lg" x-show="sidebarOpen">ABSENSI PKL</span>

        <button @click="sidebarOpen = !sidebarOpen" class="focus:outline-none">
            ☰
        </button>
    </div>

    {{-- MENU --}}
    <nav class="flex-1 px-2 space-y-1 overflow-hidden">

        {{-- ADMIN --}}
        @if(auth()->user()->role === 'admin')

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2 rounded hover:bg-blue-700">

                <span>🏠</span>
                <span x-show="sidebarOpen">Dashboard</span>
            </a>

            <a href="{{ route('admin.users.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded hover:bg-blue-700">

                <span>👤</span>
                <span x-show="sidebarOpen">Manajemen User</span>
            </a>

            <a href="{{ route('admin.guru.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded hover:bg-blue-700">

                <span>👨‍🏫</span>
                <span x-show="sidebarOpen">Master Guru</span>
            </a>

            <a href="{{ route('admin.siswa.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded hover:bg-blue-700">

                <span>🎓</span>
                <span x-show="sidebarOpen">Master Siswa</span>
            </a>

            <a href="{{ route('admin.tempat-pkl.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded hover:bg-blue-700">

                <span>🏭</span>
                <span x-show="sidebarOpen">Master Bengkel</span>
            </a>

            {{-- KOREKSI ABSEN --}}
            <a href="{{ route('admin.koreksi-absensi.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded hover:bg-blue-700">

                <span>📝</span>
                <span x-show="sidebarOpen">Koreksi Absensi</span>
            </a>

            <a href="{{ route('admin.rekap') }}"
               class="flex items-center gap-3 px-3 py-2 rounded hover:bg-blue-700">

                <span>📊</span>
                <span x-show="sidebarOpen">Rekap Absensi</span>
            </a>

            <a href="{{ route('admin.izin.index') }}"
                class="flex items-center gap-3 px-3 py-2 rounded hover:bg-blue-700">

                 <span>📩</span>
                 <span x-show="sidebarOpen">Monitoring Izin</span>
                 </a>

        @endif

        {{-- GURU --}}
        @if(auth()->user()->role === 'guru')

            <a href="{{ route('guru.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2 rounded hover:bg-blue-700">
                <span>🏠</span>
                <span x-show="sidebarOpen">Dashboard Guru</span>
            </a>

            <a href="{{ route('guru.absensi') }}"
               class="flex items-center gap-3 px-3 py-2 rounded hover:bg-blue-700">
                <span>📍</span>
                <span x-show="sidebarOpen">Monitoring Absen</span>
            </a>

            <a href="{{ route('guru.izin') }}"
               class="flex items-center gap-3 px-3 py-2 rounded hover:bg-blue-700">
                <span>📩</span>
                <span x-show="sidebarOpen">Persetujuan Izin</span>
            </a>

            <a href="{{ route('guru.koreksi-absensi') }}"
               class="flex items-center gap-3 px-3 py-2 rounded hover:bg-blue-700">
                <span>📝</span>
                <span x-show="sidebarOpen">Koreksi Absensi</span>
            </a>

            <a href="{{ route('guru.laporan') }}"
               class="flex items-center gap-3 px-3 py-2 rounded hover:bg-blue-700">
                <span>📄</span>
                <span x-show="sidebarOpen">Laporan Kehadiran</span>
            </a>

        @endif

    </nav>
</div>
