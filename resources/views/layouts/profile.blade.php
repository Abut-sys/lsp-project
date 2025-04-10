<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'User Profile')</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-gray-100 min-h-screen">
    <div x-data="{
        open: window.innerWidth >= 768,
        mobileMenuOpen: false,
        isMobile: window.innerWidth < 768
    }" x-init="() => {
        window.addEventListener('resize', () => {
            isMobile = window.innerWidth < 768;
            if (!isMobile) mobileMenuOpen = false;
        });
    }"
        class="relative flex flex-col md:flex-row md:justify-center p-4 md:p-6 gap-4 md:gap-6">

        <!-- Mobile Menu Toggle -->
        <button @click="mobileMenuOpen = !mobileMenuOpen"
            class="md:hidden fixed bottom-4 right-4 z-50 bg-white p-4 rounded-full shadow-lg border border-gray-200
                   hover:bg-blue-100 transition-all duration-300">
            <i class="fas fa-bars text-gray-700 text-xl"></i>
        </button>

        <!-- Back Button -->
        <a href="{{ route('welcome.home') }}"
            class="absolute top-4 left-4 md:-left-12 md:top-2 bg-white text-gray-700 p-3 rounded-full shadow-md border border-gray-200
                   hover:bg-red-600 hover:text-white active:bg-red-700 transition-transform transform hover:scale-105
                   z-50 flex items-center justify-center">
            <i class="fa-solid fa-arrow-left text-lg"></i>
        </a>

        <!-- Sidebar for Mobile -->
        <div class="md:hidden fixed inset-0 bg-black/50 z-40" x-show="mobileMenuOpen" @click="mobileMenuOpen = false"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        </div>

        <!-- Sidebar -->
        <div class="transform transition-all duration-300 fixed md:relative md:translate-x-0 z-40
                   h-screen md:h-auto w-64 md:w-auto top-0 left-0"
            :class="mobileMenuOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0">

            <div class="h-full bg-white shadow-xl md:shadow-lg rounded-xl p-4 flex flex-col
                       transition-all duration-300"
                :class="open ? 'w-64' : 'w-16'">

                <!-- Header Sidebar -->
                <div class="flex items-center justify-between mb-6">
                    <h2 x-show="open" class="text-xl font-bold text-gray-800 truncate">
                        Hi, {{ Auth::user()->name }}
                    </h2>
                    <button @click="open = !open; if(isMobile) mobileMenuOpen = false"
                        class="p-2 rounded-lg hover:bg-gray-100 transition">
                        <i class="fas fa-bars text-gray-600"></i>
                    </button>
                </div>

                <!-- Tambahkan Tombol Back di sini -->
                <a href="{{ route('welcome.home') }}"
                    class="flex items-center space-x-3 p-3 rounded-lg transition-all duration-200
                  hover:bg-gray-100 mb-4">
                    <i class="fas fa-arrow-left text-lg text-gray-700 w-6 text-center"></i>
                    <span x-show="open" class="text-sm font-medium text-gray-700 truncate">
                        Kembali ke Beranda
                    </span>
                </a>

                <!-- Menu Items -->
                <nav class="space-y-2 flex-1">
                    <a href="{{ route('user.profile') }}"
                        class="flex items-center space-x-3 p-3 rounded-lg transition-all duration-200
                               {{ Request::routeIs('user.profile') ? 'bg-blue-100 border-l-4 border-blue-500' : 'hover:bg-gray-100' }}">
                        <i class="fas fa-user text-lg text-blue-600 w-6 text-center"></i>
                        <span x-show="open" class="text-sm font-medium text-gray-700 truncate">Profil Saya</span>
                    </a>

                    <a href="{{ route('wishlist.index') }}"
                        class="flex items-center space-x-3 p-3 rounded-lg transition-all duration-200
                               {{ Request::routeIs('wishlist.index') ? 'bg-pink-100 border-l-4 border-pink-500' : 'hover:bg-gray-100' }}">
                        <i class="fas fa-heart text-lg text-pink-500 w-6 text-center"></i>
                        <span x-show="open" class="text-sm font-medium text-gray-700 truncate">Wishlist</span>
                    </a>

                    <a href="{{ route('booking.history') }}"
                        class="flex items-center space-x-3 p-3 rounded-lg transition-all duration-200
                               {{ Request::routeIs('booking.history') ? 'bg-yellow-100 border-l-4 border-yellow-500' : 'hover:bg-gray-100' }}">
                        <i class="fas fa-history text-lg text-yellow-500 w-6 text-center"></i>
                        <span x-show="open" class="text-sm font-medium text-gray-700 truncate">Riwayat</span>
                    </a>

                    <a href="#"
                        class="flex items-center space-x-3 p-3 rounded-lg transition-all duration-200
                               {{ Request::routeIs('user.settings') ? 'bg-green-100 border-l-4 border-green-500' : 'hover:bg-gray-100' }}">
                        <i class="fas fa-cog text-lg text-green-600 w-6 text-center"></i>
                        <span x-show="open" class="text-sm font-medium text-gray-700 truncate">Pengaturan</span>
                    </a>
                </nav>

                <!-- Logout Button -->
                <div class="mt-auto border-t pt-4">
                    <form action="{{ route('user.logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center space-x-3 p-3 rounded-lg text-red-600
                                   hover:bg-red-100 transition-all duration-200">
                            <i class="fas fa-sign-out-alt text-lg w-6 text-center"></i>
                            <span x-show="open" class="text-sm font-medium">Keluar Akun</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 transition-all duration-300 bg-white rounded-xl shadow-md p-6 md:p-8
                   min-h-[calc(100vh-100px)] md:min-h-auto"
            :class="open && !isMobile ? 'md:ml-6' : 'md:ml-2'">
            @yield('content')
        </div>
    </div>
</body>

</html>
