@extends('layouts.auth')

@section('title', 'Register dengan Nomor Telepon')

@section('content')
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Buat Akun</h2>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-600 rounded-lg">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('user.register.phone.submit') }}" method="POST" onsubmit="formatPhoneNumber()">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-semibold">Nama</label>
            <input type="text" name="name" id="name"
                class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none" required
                value="{{ old('name') }}">
        </div>

        <div class="mb-4">
            <label for="phone_number" class="block text-gray-700 font-semibold">Nomor Telepon</label>
            <div class="flex border rounded-lg overflow-hidden">
                <span class="bg-gray-200 p-3 border-r text-gray-700">+62</span>
                <input type="text" name="phone_number" id="phone_number"
                    class="w-full p-3 focus:ring-2 focus:ring-green-500 focus:outline-none" required
                    value="{{ old('phone_number') }}" placeholder="81234567890">
            </div>
        </div>

        <div class="mb-4">
            <label for="password" class="block text-gray-700 font-semibold">Password</label>
            <input type="password" name="password" id="password"
                class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none" required>
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="block text-gray-700 font-semibold">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none" required>
        </div>

        <button type="submit"
            class="w-full bg-green-500 text-white p-3 rounded-lg hover:bg-green-600 transition duration-300 shadow-md">
            Register dengan Nomor Telepon
        </button>
    </form>

    <div class="flex items-center my-6">
        <hr class="flex-grow border-gray-300">
        <span class="mx-4 text-gray-500">atau</span>
        <hr class="flex-grow border-gray-300">
    </div>

    <a href="{{ route('user.register.email') }}"
        class="w-full bg-blue-500 text-white p-3 rounded-lg block text-center hover:bg-blue-600 transition duration-300 shadow-md">
        Register dengan Email
    </a>

    <p class="text-center mt-4 text-gray-600">
        Sudah punya akun?
        <a href="{{ route('user.login.phone') }}" class="text-blue-500 hover:underline">Login</a>
    </p>

    <script>
        function formatPhoneNumber() {
            let phoneInput = document.getElementById("phone_number");
            phoneInput.value = "+62" + phoneInput.value.trim();
            console.log("Nomor yang dikirim:", phoneInput.value);
        }
    </script>
@endsection
