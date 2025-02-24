@extends('layouts.auth')

@section('title', 'Login dengan Email')

@section('content')
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Login dengan Email</h2>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-600 rounded-lg">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('user.login.email.submit') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-semibold">Email</label>
            <input type="email" name="email" id="email"
                class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" required
                value="{{ old('email') }}">
        </div>

        <div class="mb-4">
            <label for="password" class="block text-gray-700 font-semibold">Password</label>
            <input type="password" name="password" id="password"
                class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
        </div>

        <div class="mb-4 flex items-center">
            <input type="checkbox" name="remember" id="remember" class="mr-2">
            <label for="remember" class="text-gray-700">Ingat Saya</label>
        </div>

        <button type="submit"
            class="w-full bg-blue-500 text-white p-3 rounded-lg hover:bg-blue-600 transition duration-300 shadow-md">
            Login dengan Email
        </button>
    </form>

    <div class="flex items-center my-6">
        <hr class="flex-grow border-gray-300">
        <span class="mx-4 text-gray-500">atau</span>
        <hr class="flex-grow border-gray-300">
    </div>

    <a href="{{ route('user.login.phone') }}"
        class="w-full bg-green-500 text-white p-3 rounded-lg block text-center hover:bg-green-600 transition duration-300 shadow-md">
        Login dengan Nomor Telepon
    </a>

    <p class="text-center mt-4 text-gray-600">
        Belum punya akun?
        <a href="{{ route('user.register.email') }}" class="text-blue-500 hover:underline">Daftar Sekarang</a>
    </p>
@endsection
