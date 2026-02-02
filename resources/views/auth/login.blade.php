<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | E-Prakerin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900 transition">

<!-- DARK MODE SCRIPT -->
<script>
    if (localStorage.theme === 'dark') {
        document.documentElement.classList.add('dark')
    }
</script>

<div class="w-full max-w-md px-6">

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 transition">

        <!-- LOGO SEKOLAH -->
        <div class="flex justify-center mb-4">
            <img src="/images/logo-sekolah.png"
                 alt="Logo Sekolah"
                 class="w-20 h-20 object-contain">
        </div>

        <!-- TITLE -->
        <h1 class="text-2xl font-bold text-center text-gray-800 dark:text-white">
            E-Prakerin
        </h1>
        <p class="text-center text-gray-500 dark:text-gray-400 mt-1 mb-6">
            Silakan masuk untuk melanjutkan
        </p>

        <!-- ERROR -->
        @if(session('error'))
            <div class="bg-red-100 text-red-600 text-sm p-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- FORM -->
        <form method="POST" action="/login" class="space-y-4">
            @csrf

            <!-- USERNAME -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Username
                </label>
                <input name="username"
                       class="w-full px-4 py-2 border rounded-lg
                              bg-white dark:bg-gray-700
                              text-gray-800 dark:text-white
                              focus:ring focus:ring-indigo-300"
                       required>
            </div>

            <!-- PASSWORD -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Kata Sandi
                </label>
                <div class="relative">
                    <input type="password" id="password" name="password"
                           class="w-full px-4 py-2 border rounded-lg
                                  bg-white dark:bg-gray-700
                                  text-gray-800 dark:text-white
                                  focus:ring focus:ring-indigo-300"
                           required>

                    </div>
            </div>

            <!-- BUTTON -->
            <button class="w-full bg-indigo-600 hover:bg-indigo-700
                           text-white font-semibold py-2 rounded-lg transition">
                Masuk
            </button>
        </form>

        <!-- DARK MODE TOGGLE -->
        <div class="flex justify-center mt-4">
            <button onclick="toggleDarkMode()"
                    class="text-xs text-gray-500 dark:text-gray-400">
                🌙 Dark Mode
            </button>
        </div>

        <p class="text-xs text-center text-gray-400 mt-4">
            Sistem Absensi PKL
        </p>

    </div>
</div>

<!-- JS -->
<script>
    function togglePassword() {
        const input = document.getElementById('password');
        input.type = input.type === 'password' ? 'text' : 'password';
    }

    function toggleDarkMode() {
        document.documentElement.classList.toggle('dark');
        localStorage.theme =
            document.documentElement.classList.contains('dark')
            ? 'dark'
            : 'light';
    }
</script>

</body>
</html>