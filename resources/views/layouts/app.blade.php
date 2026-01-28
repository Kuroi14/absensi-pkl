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
        
</head>

<body class="h-screen bg-gray-100" x-data="{ sidebarOpen: true }">

<div class="flex h-full">

    {{-- SIDEBAR --}}
    @include('components.sidebar')

    {{-- MAIN --}}
    <div class="flex-1 flex flex-col">

        {{-- HEADER --}}
        <header class="bg-white shadow px-6 py-4">
    <div class="flex justify-end items-center gap-4">
        <span class="text-sm text-gray-700">
            {{ auth()->user()->nama }} ({{ auth()->user()->role }})
        </span>

        <form method="POST" action="/logout">
            @csrf
            <button class="text-sm text-red-600 hover:underline">
                Logout
            </button>
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
