<nav class="bg-white/70 backdrop-blur-lg shadow-sm border-b border-gray-200/50 p-4 fixed w-full top-0 z-50 transition-all duration-300 hover:bg-white/80">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <!-- Logo dengan efek transparan -->
        <div class="flex-1">
            <a href="{{ url('/') }}" class="flex items-center group transform transition-all duration-300 hover:scale-105">
                <span class="text-3xl font-bold bg-gradient-to-r from-blue-600/90 to-orange-500/90 bg-clip-text text-transparent">
                    BookNStay
                </span>
            </a>
        </div>
        
        <!-- Navigation Links -->
        <div class="flex items-center gap-8">
            @guest
                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ route('user.login.email') }}"
                       class="text-gray-700 hover:text-blue-600 transition-all font-medium
                             relative group">
                        <span class="relative z-10 flex items-center">
                            <i class="fas fa-sign-in-alt mr-2 text-blue-400/80"></i>
                            Login
                        </span>
                        <div class="absolute bottom-0 left-0 w-full h-px bg-blue-600/30
                                  transform scale-x-0 group-hover:scale-x-100 transition-transform
                                  duration-300 origin-left"></div>
                    </a>
                    <a href="{{ route('user.register.email') }}"
                       class="relative overflow-hidden bg-gradient-to-r from-blue-500/90 to-blue-600/90
                             text-white px-6 py-2.5 rounded-xl hover:shadow-xl transition-all duration-500
                             transform hover:-translate-y-0.5">
                        <span class="relative z-10">Register</span>
                        <div class="absolute inset-0 bg-white/10 opacity-0 hover:opacity-20 transition-opacity"></div>
                    </a>
                </div>
            @endguest

            @auth
                <!-- User Dropdown dengan transparansi -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.away="open = false"
                            class="flex items-center space-x-2 group focus:outline-none transform
                                   transition-all duration-300 hover:scale-105">
                        <div class="w-10 h-10 bg-blue-600/90 rounded-full flex items-center justify-center
                                  text-white font-medium shadow-lg backdrop-blur-sm">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5 text-gray-600/80 transition-all duration-300 group-hover:text-gray-800"
                             :class="{ 'rotate-180': open, 'text-blue-600/90': open }" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                  clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu Glassmorphism -->
                    <div x-show="open" x-cloak
                         class="absolute right-0 mt-2 w-56 origin-top-right bg-white/90 backdrop-blur-lg
                                rounded-xl shadow-xl ring-1 ring-black/5 overflow-hidden
                                border border-white/20">
                        <a href="{{ route('user.profile') }}"
                           class="flex items-center px-4 py-3 text-gray-700 hover:bg-white/30
                                  transition-all duration-300">
                            <i class="fas fa-user-circle text-lg text-blue-400/80 mr-2"></i>
                            My Profile
                        </a>
                        <form action="{{ route('user.logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="w-full text-left flex items-center px-4 py-3 text-red-600/90
                                           hover:bg-red-100/30 transition-all duration-300
                                           border-t border-white/20">
                                <i class="fas fa-sign-out-alt text-lg text-red-400/80 mr-2"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</nav>
