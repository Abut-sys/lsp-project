@extends('layouts.auth')

@section('title', 'Verifikasi OTP')

@section('content')
    <div class="space-y-8">
        <!-- Header Section -->
        <div class="text-center space-y-4">
            <div class="animate-bounce">
                <svg class="w-16 h-16 mx-auto text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                    </path>
                </svg>
            </div>
            <h2 class="text-4xl font-bold text-gray-900">Verifikasi OTP</h2>
            <p class="text-gray-500">Masukkan 6-digit kode yang dikirim ke email Anda</p>
        </div>

        <!-- Alerts -->
        @if (session('error'))
            <div class="p-4 bg-red-50 border-l-4 border-red-400 flex items-center space-x-3 animate-fade-in">
                <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span class="text-red-600">{{ session('error') }}</span>
            </div>
        @endif

        @if (session('success'))
            <div class="p-4 bg-green-50 border-l-4 border-green-400 flex items-center space-x-3 animate-fade-in">
                <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-green-600">{{ session('success') }}</span>
            </div>
        @endif

        <!-- OTP Form -->
        <form action="{{ route('password.checkotp') }}" method="POST" class="space-y-8 max-w-md mx-auto">
            @csrf

            <!-- OTP Inputs -->
            <div class="flex justify-center gap-3 group">
                @for ($i = 1; $i <= 6; $i++)
                    <input type="text" name="otp[]" maxlength="1"
                        class="otp-input w-14 h-14 text-3xl text-center font-bold text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl
                       focus:border-blue-500 focus:ring-4 focus:ring-blue-200 focus:scale-105
                       transition-all duration-150 shadow-sm hover:shadow-md"
                        autocomplete="off" {{ $i == 1 ? 'autofocus' : '' }}>
                @endfor
            </div>
            <input type="hidden" name="otp_full" id="otpFull">

            <!-- Submit Button -->
            <button type="submit"
                class="w-full py-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold rounded-xl
                   hover:from-blue-600 hover:to-blue-700 hover:shadow-lg
                   active:scale-95 transition-all duration-300">
                Verifikasi Sekarang
            </button>
        </form>

        <!-- Resend Section -->
        <div class="text-center space-y-4 max-w-md mx-auto">
            <p class="text-gray-500" id="resendText">
                Tidak menerima kode?
                <span id="countdown" class="hidden text-blue-500">00:30</span>
                <a href="{{ route('password.request') }}" id="resendLink"
                    class="text-blue-500 hover:text-blue-600 hover:underline font-medium transition-colors duration-300">
                    Kirim Ulang OTP
                </a>
            </p>
            <a href="{{ route('user.login.email') }}"
                class="inline-block text-gray-400 hover:text-gray-500 text-sm transition-colors duration-300">
                ← Kembali ke Login
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const otpInputs = document.querySelectorAll('.otp-input');
            const otpForm = document.querySelector('form');
            const otpFullInput = document.getElementById('otpFull');
            let countdown = 30;
            const countdownElement = document.getElementById('countdown');
            const resendLink = document.getElementById('resendLink');

            // OTP Input Handling
            otpInputs.forEach((input, index) => {
                input.addEventListener('input', (e) => {
                    if (e.inputType === 'insertFromPaste') {
                        handlePaste(e);
                        return;
                    }

                    if (e.target.value.length === 1) {
                        if (index < otpInputs.length - 1) {
                            otpInputs[index + 1].focus();
                        }
                    }
                    updateHiddenOtp();
                });

                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && !e.target.value && index > 0) {
                        otpInputs[index - 1].focus();
                    }
                });
            });

            // Handle OTP Paste
            function handlePaste(e) {
                const pasteData = e.clipboardData.getData('text').trim();
                if (pasteData.length === 6 && /^\d+$/.test(pasteData)) {
                    pasteData.split('').forEach((char, i) => {
                        if (otpInputs[i]) {
                            otpInputs[i].value = char;
                        }
                    });
                    otpInputs[5].focus();
                    updateHiddenOtp();
                }
            }

            // Update Hidden Field
            function updateHiddenOtp() {
                otpFullInput.value = Array.from(otpInputs).map(input => input.value).join('');
            }

            // Resend Countdown
            function startCountdown() {
                resendLink.classList.add('hidden');
                countdownElement.classList.remove('hidden');

                const timer = setInterval(() => {
                    countdown--;
                    countdownElement.textContent = `00:${countdown.toString().padStart(2, '0')}`;

                    if (countdown <= 0) {
                        clearInterval(timer);
                        countdownElement.classList.add('hidden');
                        resendLink.classList.remove('hidden');
                        countdown = 30;
                    }
                }, 1000);
            }

            // Start countdown on page load
            startCountdown();
        });
    </script>

    <style>
        .animate-fade-in {
            animation: fadeIn 0.5s ease-in;
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
    </style>
@endsection
