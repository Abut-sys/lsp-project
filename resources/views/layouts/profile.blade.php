<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'User Profile')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <!-- Main Content -->
    <main class="container mx-auto p-4">
        @yield('content') <!-- Ini adalah bagian yang akan diisi oleh profile.blade.php -->
    </main>

</body>
</html>
