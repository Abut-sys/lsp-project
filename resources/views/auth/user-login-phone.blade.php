@extends('layouts.app')

@section('title', 'Login dengan Nomor Telepon')

@section('content')
    <h2 class="text-2xl font-bold text-center mb-6">Login dengan Nomor Telepon</h2>

    @if ($errors->any())
        <div class="mb-4 text-red-500">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('user.login.phone.submit') }}" method="POST" onsubmit="formatPhoneNumber()">
        @csrf
        <div class="mb-4">
            <label for="phone_number" class="block text-gray-700">Nomor Telepon</label>
            <div class="flex border rounded overflow-hidden">
                <span class="bg-gray-200 p-2 border-r text-gray-700">+62</span>
                <input type="text" name="phone_number" id="phone_number" class="w-full p-2" required
                    value="{{ old('phone_number') }}" placeholder="81234567890">
            </div>
        </div>
        <div class="mb-4">
            <label for="password" class="block text-gray-700">Password</label>
            <input type="password" name="password" id="password" class="w-full p-2 border rounded" required>
        </div>
        <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">
            Login
        </button>
        <div class="mb-4 flex items-center">
            <input type="checkbox" name="remember" id="remember" class="mr-2">
            <label for="remember" class="text-gray-700">Ingat Saya</label>
        </div>
    </form>

    <p class="text-center mt-4">
        <a href="{{ route('user.login.email') }}" class="text-blue-500 hover:underline">Login dengan Email</a>
    </p>

    <script>
        function formatPhoneNumber() {
            let phoneInput = document.getElementById("phone_number");
            phoneInput.value = "+62" + phoneInput.value.trim();
        }
    </script>

@endsection
