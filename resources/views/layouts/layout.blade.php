<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>App</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                class="fixed top-5 right-5 bg-green-400 text-white px-4 py-2 rounded shadow-lg">
                {{ session('success') }}
            </div>
        @endif
        <!-- Page Content -->
        <main class="container mx-auto py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>
