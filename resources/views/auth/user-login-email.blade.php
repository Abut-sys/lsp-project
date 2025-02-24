@extends('layouts.app')

@section('title', 'Login dengan Email')

@section('content')
    <h2 class="text-2xl font-bold text-center mb-6">Login dengan Email</h2>

    @if ($errors->any())
        <div class="mb-4 text-red-500">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('user.login.email.submit') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email</label>
            <input type="email" name="email" id="email" class="w-full p-2 border rounded" required value="{{ old('email') }}">
        </div>
        <div class="mb-4">
            <label for="password" class="block text-gray-700">Password</label>
            <input type="password" name="password" id="password" class="w-full p-2 border rounded" required>
        </div>
        <div class="mb-4 flex items-center">
            <input type="checkbox" name="remember" id="remember" class="mr-2">
            <label for="remember" class="text-gray-700">Ingat Saya</label>
        </div>
        <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">
            Login
        </button>
    </form>

    <p class="text-center mt-4">
        <a href="{{ route('user.login.phone') }}" class="text-blue-500 hover:underline">Login dengan Nomor Telepon</a>
    </p>
@endsection
