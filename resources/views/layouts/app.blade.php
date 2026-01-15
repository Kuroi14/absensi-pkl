<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Absensi PKL</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="stylesheet"href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

</head>

<body class="h-screen bg-gray-100" x-data="{ sidebarOpen: true }">

<div class="flex h-full">

    {{-- SIDEBAR --}}
    @include('components.sidebar')

    {{-- MAIN --}}
    <div class="flex-1 flex flex-col">

        {{-- HEADER --}}
        <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
            <button @click="sidebarOpen = !sidebarOpen">☰</button>

            <div class="flex items-center gap-4">
                <span class="text-sm">
                    {{ auth()->user()->nama }} ({{ auth()->user()->role }})
                </span>

                <form method="POST" action="/logout">
                    @csrf
                    <button class="text-red-600">Logout</button>
                </form>
            </div>
        </header>

        {{-- CONTENT --}}
        <main class="flex-1 p-6 overflow-y-auto">
            @yield('content')
        </main>

    </div>
</div>

</body>
</html>
