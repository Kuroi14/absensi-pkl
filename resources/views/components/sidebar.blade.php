<div
    class="bg-blue-800 text-white transition-all duration-300"
    :class="sidebarOpen ? 'w-64' : 'w-16'"
>

    <div class="p-4 font-bold text-lg text-center">
        <span x-show="sidebarOpen">ABSENSI PKL</span>
        <span x-show="!sidebarOpen">AP</span>
    </div>

   <nav class="px-2 space-y-1">

    {{-- ADMIN --}}
    @if(auth()->user()->role === 'admin')
        <a href="/dashboard"
           class="block px-4 py-2 rounded hover:bg-blue-700">
            🏠 <span x-show="sidebarOpen">Dashboard Admin</span>
        </a>

        <a href="/users"
           class="block px-4 py-2 rounded hover:bg-blue-700">
            👤 <span x-show="sidebarOpen">Manajemen User</span>
        </a>

        <a href="/guru"
           class="block px-4 py-2 rounded hover:bg-blue-700">
            👨‍🏫 <span x-show="sidebarOpen">Master Guru</span>
        </a>

        <a href="/siswa"
           class="block px-4 py-2 rounded hover:bg-blue-700">
            👨‍🎓 <span x-show="sidebarOpen">Master Siswa</span>
        </a>

        <a href="/rekap"
           class="block px-4 py-2 rounded hover:bg-blue-700">
            📑 <span x-show="sidebarOpen">Rekap Absensi</span>
        </a>

        <a href="/tempat-pkl"
   class="block px-4 py-2 rounded hover:bg-blue-700">
    🏭 <span x-show="sidebarOpen">Master Bengkel</span>
</a>
    @endif

    {{-- GURU --}}
    @if(auth()->user()->role === 'guru')
        <a href="/guru/dashboard"
           class="block px-4 py-2 rounded hover:bg-blue-700">
            📊 <span x-show="sidebarOpen">Dashboard Guru</span>
        </a>

        <a href="/rekap"
           class="block px-4 py-2 rounded hover:bg-blue-700">
            📑 <span x-show="sidebarOpen">Rekap Siswa PKL</span>
        </a>
    @endif

    {{-- SISWA --}}
    @if(auth()->user()->role === 'siswa')
        <a href="/siswa/dashboard"
           class="block px-4 py-2 rounded hover:bg-blue-700">
            🏠 <span x-show="sidebarOpen">Dashboard Siswa</span>
        </a>

        <a href="/absensi"
           class="block px-4 py-2 rounded hover:bg-blue-700">
            📍 <span x-show="sidebarOpen">Absensi PKL</span>
        </a>
    @endif

</nav>
</div>
