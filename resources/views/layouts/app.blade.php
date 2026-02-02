<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>E-Prakerin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="stylesheet"href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
        
<head>
    <meta charset="UTF-8">
    <title>E-Prakerin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="min-h-screen bg-gray-100">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-blue-800 text-white min-h-screen flex flex-col">
        @include('components.sidebar')
    </aside>

    {{-- MAIN AREA --}}
    <div class="flex-1 flex flex-col">

        {{-- HEADER --}}
        <header class="bg-white shadow px-6 py-4 flex justify-end items-center gap-4">
            <span class="text-sm text-gray-700">
                {{ auth()->user()->nama }} ({{ auth()->user()->role }})
            </span>

            <form method="POST" action="/logout">
                @csrf
                <button class="text-sm text-red-600 hover:underline">
                    Logout
                </button>
            </form>
        </header>

        {{-- CONTENT --}}
        <main class="flex-1 p-6">
            @yield('content')
        </main>

        {{-- FOOTER --}}
        <footer class="bg-white border-t text-center text-sm text-gray-500 py-3">
            © {{ date('Y') }} E-Prakerin — Sistem Absensi PKL
        </footer>

    </div>
</div>

</body>
</html>
