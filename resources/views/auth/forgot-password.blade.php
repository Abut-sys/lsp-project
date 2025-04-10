@extends('layouts.auth')

@section('title', 'Lupa Password')

@section('content')
    <div class="space-y-8">
        <!-- Header Section -->
        <div class="text-center space-y-4">
            <div class="animate-bounce inline-block">
                <svg class="w-16 h-16 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-900">Reset Password</h2>
            <p class="text-gray-500">Masukkan email untuk menerima OTP</p>
        </div>

        <!-- Status & Error Messages -->
        @if (session('status'))
            <div class="p-4 bg-green-50 border-l-4 border-green-400 rounded-lg flex items-center space-x-3 animate-fade-in">
                <svg class="w-6 h-6 text-green-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-green-600">{{ session('status') }}</span>
            </div>
        @endif

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

        <!-- Form -->
        <form action="{{ route('password.sendotp') }}" method="POST" class="space-y-6 max-w-md mx-auto">
            @csrf

            <!-- Email Input -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <div class="relative flex1 group">
                    <input type="email" name="email" id="email" required value="{{ old('email') }}"
                        class="w-full p-4 pl-12 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-200
                           transition-all duration-300 placeholder-gray-400 peer"
                        placeholder="email@example.com">
                    <svg class="w-6 h-6 absolute left-4 top-4 text-gray-400 transition-colors duration-300 group-focus-within:text-blue-500"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full py-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold rounded-xl
                   hover:from-blue-600 hover:to-blue-700 hover:shadow-lg transform transition-all
                   active:scale-95 duration-300">
                Kirim OTP
            </button>
        </form>

        <!-- Back Link -->
        <div class="text-center">
            <a href="{{ route('user.login.email') }}"
                class="text-blue-500 hover:text-blue-600 font-medium transition-colors flex items-center justify-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Login
            </a>
        </div>
    </div>

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
    </style>
@endsection
