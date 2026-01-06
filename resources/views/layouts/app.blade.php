<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Absensi PKL</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="h-screen bg-gray-100" x-data="{ sidebarOpen: true }">

<div class="flex h-full">

    {{-- SIDEBAR --}}
    @include('components.sidebar')

    {{-- CONTENT --}}
    <div class="flex-1 flex flex-col">

        {{-- HEADER --}}
        <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
            <button @click="sidebarOpen = !sidebarOpen"
                    class="text-gray-600 hover:text-gray-900">
                ☰
            </button>

            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-600">
                    {{ auth()->user()->nama }} ({{ auth()->user()->role }})
                </span>

                <form method="POST" action="/logout">
                    @csrf
                    <button class="text-red-600 hover:underline text-sm">
                        Logout
                    </button>
                </form>
            </div>
        </header>

        {{-- MAIN --}}
        <main class="flex-1 p-6 overflow-y-auto">
            @yield('content')
        </main>

    </div>
</div>

</body>
</html>
