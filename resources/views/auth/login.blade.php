<!doctype html>
<html>
<head>
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">

<form method="POST" action="/login" class="bg-white p-6 rounded shadow w-80">
    @csrf

    <h2 class="text-xl font-bold mb-4 text-center">Login</h2>

    @if(session('error'))
        <div class="text-red-500 text-sm mb-2">
            {{ session('error') }}
        </div>
    @endif

    <input name="username"
           placeholder="Username"
           class="w-full border p-2 mb-3 rounded"
           required>

    <input type="password"
           name="password"
           placeholder="Password"
           class="w-full border p-2 mb-4 rounded"
           required>

    <button class="w-full bg-blue-600 text-white py-2 rounded">
        Masuk
    </button>
</form>

</body>
</html>
