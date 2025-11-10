<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MUA Panel')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-pink-50 text-gray-800">
    <div class="min-h-screen flex flex-col">
        <header class="bg-white shadow-md p-4 flex justify-between items-center">
            <h1 class="font-bold text-xl text-pink-600">MUA Panel</h1>
            <a href="/" class="text-gray-600 hover:text-pink-600">Dashboard</a>
        </header>

        <main class="flex-1 container mx-auto p-6">
            @yield('content')
        </main>

        <footer class="text-center py-4 text-gray-500 text-sm">
            © 2025 AdatKu — MUA Panel
        </footer>
    </div>
</body>

</html>