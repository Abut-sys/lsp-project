<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Reservation</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <header class="bg-white shadow">
        <div class="container mx-auto px-4 py-6 flex justify-between">
            <a href="{{ route('welcome') }}" class="text-xl font-bold">Hotel Reservation</a>
            <nav>
                <a href="{{ route('welcome') }}" class="mr-4">Home</a>
                <a href="#" class="mr-4">Rooms</a>
                @auth
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-red-500">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-blue-500">Login</a>
                @endauth
            </nav>
        </div>
    </header>
    <main class="py-8">
        @yield('content')
    </main>
    <footer class="bg-white shadow py-4 text-center">
        &copy; 2025 Hotel Reservation
    </footer>
</body>
</html>
