@extends('layouts.auth')

@section('title', 'Register dengan Email')

@section('content')
    <div class="space-y-8">
        <!-- Header Section -->
        <div class="text-center space-y-4">
            <div class="animate-bounce inline-block">
                <svg class="w-16 h-16 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-900">Buat Akun Baru</h2>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="p-4 bg-red-50 border-l-4 border-red-400 rounded-lg flex items-center space-x-3 animate-fade-in">
                <svg class="w-6 h-6 text-red-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div class="text-red-600 text-sm">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Registration Form -->
        <form action="{{ route('user.register.email.submit') }}" method="POST" class="space-y-6 max-w-md mx-auto">
            @csrf

            <!-- Name Input -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <div class="relative flex1 group">
                    <input type="text" name="name" id="name" required value="{{ old('name') }}"
                        class="w-full p-4 pl-12 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-200
                           transition-all duration-300 placeholder-gray-400 peer"
                        placeholder="Byankun">
                    <svg class="w-6 h-6 absolute left-4 top-4 text-gray-400 transition-colors duration-300 group-focus-within:text-blue-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
            </div>

            <!-- Email Input -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <div class="relative flex1 group">
                    <input type="email" name="email" id="email" required value="{{ old('email') }}"
                        class="w-full p-4 pl-12 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-200
                           transition-all duration-300 placeholder-gray-400 peer"
                        placeholder="email@example.com">
                    <svg class="w-6 h-6 absolute left-4 top-4 text-gray-400 transition-colors duration-300 group-focus-within:text-blue-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>

            <!-- Password Input -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <div class="relative flex1 group">
                    <input type="password" name="password" id="password" required
                        class="w-full p-4 pl-12 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-200
                           transition-all duration-300 placeholder-gray-400 peer"
                        placeholder="••••••••">
                    <svg class="w-6 h-6 absolute left-4 top-4 text-gray-400 transition-colors duration-300 group-focus-within:text-blue-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <button type="button" onclick="togglePassword('password')"
                        class="absolute right-4 top-4 text-gray-400 hover:text-blue-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <!-- Mata terbuka (default) -->
                            <path class="eye-open opacity-100 transition-opacity" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />

                            <!-- Mata tertutup -->
                            <path class="eye-closed absolute inset-0 opacity-0 transition-opacity" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M10.586 10.586l4.243 4.243M4 4l3.024 3.024m3.238 3.238l2.853 2.853m2.334 2.334l.541.541M2 2l20 20" />
                        </svg>
                    </button>
                </div>
                <div class="password-strength mt-2 h-2 rounded-full bg-gray-200 overflow-hidden">
                    <div class="h-full bg-gray-400 transition-all duration-500" id="password-strength-bar"></div>
                </div>
            </div>

            <!-- Confirm Password Input -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                <div class="relative flex1 group">
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="w-full p-4 pl-12 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-200
                           transition-all duration-300 placeholder-gray-400 peer"
                        placeholder="••••••••">
                    <svg class="w-6 h-6 absolute left-4 top-4 text-gray-400 transition-colors duration-300 group-focus-within:text-blue-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full py-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold rounded-xl
                   hover:from-blue-600 hover:to-blue-700 hover:shadow-lg transform transition-all
                   active:scale-95 duration-300">
                Daftar dengan Email
            </button>
        </form>

        <!-- Separator -->
        <div class="max-w-md mx-auto flex items-center my-6">
            <hr class="flex-grow border-gray-200">
            <span class="mx-4 text-gray-400 text-sm">atau</span>
            <hr class="flex-grow border-gray-200">
        </div>

        <!-- Alternative Registration -->
        <div class="space-y-4 max-w-md mx-auto">
            <a href="{{ route('user.register.phone') }}"
                class="w-full p-4 bg-green-500 text-white rounded-xl flex items-center justify-center space-x-2
                   hover:bg-green-600 transition-all duration-300 shadow-sm hover:shadow-md">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                <span>Daftar dengan Nomor Telepon</span>
            </a>

            <p class="text-center text-gray-500">
                Sudah punya akun?
                <a href="{{ route('user.login.email') }}" class="text-blue-500 hover:underline font-medium">Masuk
                    Sekarang</a>
            </p>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const button = event.currentTarget;
            const isVisible = passwordField.type === 'text';

            // Toggle tipe input
            passwordField.type = isVisible ? 'password' : 'text';

            // Toggle kelas untuk animasi ikon
            button.classList.toggle('password-visible', !isVisible);
        }

        // Password Strength Indicator
        document.getElementById('password').addEventListener('input', function(e) {
            const strengthBar = document.getElementById('password-strength-bar');
            const strength = calculatePasswordStrength(e.target.value);

            strengthBar.style.width = strength.percentage + '%';
            strengthBar.className = `h-full transition-all duration-500 ${strength.color}`;
        });

        function calculatePasswordStrength(password) {
            const strength = {
                percentage: 0,
                color: 'bg-red-500'
            };

            if (password.length >= 8) strength.percentage += 30;
            if (password.match(/[A-Z]/)) strength.percentage += 20;
            if (password.match(/[0-9]/)) strength.percentage += 25;
            if (password.match(/[^A-Za-z0-9]/)) strength.percentage += 25;

            if (strength.percentage >= 75) {
                strength.color = 'bg-green-500';
            } else if (strength.percentage >= 50) {
                strength.color = 'bg-yellow-500';
            } else {
                strength.color = 'bg-red-500';
            }

            return strength;
        }
    </script>

    <style>
        .animate-bounce {
            animation: bounce 2s infinite;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .password-visible .eye-open {
            opacity: 0;
        }

        .password-visible .eye-closed {
            opacity: 1;
        }
    </style>
@endsection
