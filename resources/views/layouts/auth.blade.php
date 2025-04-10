<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookNStay - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-50 flex items-center justify-center min-h-screen p-4">
    <div
        class="w-full max-w-xl bg-white rounded-2xl shadow-2xl transition-all duration-300 hover:shadow-3xl overflow-hidden">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-6 text-center">
            <h1 class="text-4xl font-bold text-white mb-2 transform hover:scale-105 transition-transform duration-300">
                <span class="text-white">Book</span>
                <span class="text-orange-400">N</span>
                <span class="text-white">Stay</span>
            </h1>
            <p class="text-sl font-semibold text-blue-100">Temukan Penginapan Terbaik Anda</p>
        </div>

        <!-- Main Content -->
        <div class="p-8 space-y-6">
            @yield('content')
        </div>

        <!-- Footer -->
        <div class="border-t border-gray-200 mt-8 py-6">
            <div class="relative">
                <!-- Decorative Divider -->
                <div class="absolute inset-x-0 top-0 flex justify-center">
                    <div
                        class="w-16 h-1 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full transform -translate-y-1/2">
                    </div>
                </div>

                <!-- Content -->
                <div class="text-center space-y-2">
                    <p class="text-sm font-medium text-gray-600">
                        &copy; 2025
                        <span class="text-blue-600 font-bold">Book</span>
                        <span class="text-orange-500 font-bold">N</span>
                        <span class="text-blue-600 font-bold">Stay</span><br>
                        <span class="text-xs font-normal text-gray-500">All rights reserved</span>
                    </p>
                    <div class="mt-1">
                        <span
                            class="inline-block px-2 py-1 text-[0.65rem] font-mono bg-gray-100 rounded-full text-gray-600
                                  shadow-sm hover:bg-gray-200 transition-colors duration-200 cursor-default">
                            v2.1.0
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
