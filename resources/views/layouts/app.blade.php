<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Extra CSS --}}
    @stack('styles')
</head>

<body>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-800 text-white flex flex-col">
            <div class="p-4 text-2xl font-bold border-b border-gray-700">
                Admin Panel
            </div>
            <nav class="flex-1 p-4 space-y-2">
                <a href="{{ route('dashboard') }}" class="block py-2 px-3
rounded hover:bg-gray-700">Dashboard</a>
                <a href="#" class="block py-2 px-3 rounded hover:bg-gray700">Users</a>
                <a href="#" class="block py-2 px-3 rounded hover:bg-gray700">Settings</a>
            </nav>
            <div class="p-4 border-t border-gray-700">
                <a href="#" class="block py-2 px-3 rounded bg-red-600 textcenter hover:bg-red-700">Logout</a>
            </div>
        </aside>
        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white shadow p-4 flex justify-between itemscenter">
                <h1 class="text-xl font-semibold">@yield('page-title', 'Dashboard')</h1>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">Hello, Admin</span>
                    <img src="https://ui-avatars.com/api/?name=Admin" class="w-10 h-10 rounded-full" alt="profile">
                </div>
            </header>
            <!-- Content -->
            <main class="p-6 flex-1">
                @yield('content')
            </main>
        </div>
    </div>
    {{-- Extra JS --}}
    @stack('scripts')
</body>

</html>
