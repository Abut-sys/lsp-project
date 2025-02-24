@extends('layouts.profile')

@section('title', 'Profile - ' . $user->name)

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold mb-4">Profil Saya</h2>

    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded-md mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('user.profile.update') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                class="mt-1 p-2 w-full border rounded-md">
            @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                class="mt-1 p-2 w-full border rounded-md">
            @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <!-- Input Nomor Telepon -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
            <div class="flex">
                <span class="p-2 bg-gray-200 border rounded-l-md text-gray-600">+62</span>
                <input type="text" id="phone_number" name="phone_number" maxlength="11"
                    value="{{ old('phone_number', substr($user->phone_number, 3)) }}"
                    class="mt-1 p-2 border rounded-r-md w-full" pattern="[0-9]{11}"
                    placeholder="Masukkan 11 digit terakhir"
                    oninput="this.value = this.value.replace(/\D/, '')">
            </div>
            @error('phone_number') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password Baru (Opsional)</label>
            <input type="password" id="password" name="password" class="mt-1 p-2 w-full border rounded-md">
            @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation"
                class="mt-1 p-2 w-full border rounded-md">
        </div>

        <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Update Profil</button>
    </form>
</div>
@endsection
