<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookNStay - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-center text-blue-600 mb-4">BookNStay</h1>

        @yield('content')

        <p class="text-center text-gray-500 text-sm mt-4">
            &copy; 2025 BookNStay. Semua hak dilindungi.
        </p>
    </div>
</body>
</html>
