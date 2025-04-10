@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
    <div class="space-y-8">
        <!-- Header Section -->
        <div class="text-center space-y-4">
            <div class="animate-bounce">
                <svg class="w-16 h-16 mx-auto text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-900">Reset Password</h2>
            <p class="text-gray-500">Masukkan password baru Anda</p>
        </div>

        <form action="{{ route('password.update') }}" method="POST" class="space-y-6 max-w-md mx-auto">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">

            <!-- Password Input -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Password Baru</label>
                <div class="relative group">
                    <input type="password" name="password" id="password" required
                        class="w-full p-4 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-200
                           transition-all duration-300 placeholder-gray-400 peer"
                        placeholder="••••••••">
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
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password Input -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                <div class="relative group">
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="w-full p-4 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-200
                           transition-all duration-300 placeholder-gray-400 peer"
                        placeholder="••••••••">
                    <button type="button" onclick="togglePassword('password_confirmation')"
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
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full py-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold rounded-xl
                   hover:from-blue-600 hover:to-blue-700 hover:shadow-lg transform transition-all
                   active:scale-95 duration-300">
                Reset Password
            </button>
        </form>

        <!-- Back to Login -->
        <div class="text-center max-w-md mx-auto">
            <a href="{{ route('user.login.email') }}"
                class="text-blue-500 hover:text-blue-600 font-medium transition-colors flex items-center justify-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Login
            </a>
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

            // Add strength calculations
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

        .password-visible .eye-open {
            opacity: 0;
        }

        .password-visible .eye-closed {
            opacity: 1;
        }
    </style>
@endsection
