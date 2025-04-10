@extends('layouts.profile')

@section('title', 'Profil - ' . Auth::user()->name)

@section('content')
    <div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8 space-y-8">
        <!-- Header Section -->
        <div class="relative bg-gradient-to-r from-blue-500 to-indigo-600 p-8 text-center rounded-2xl overflow-hidden">
            <div class="relative">
                <h1 class="mt-4 text-4xl font-bold text-white">
                    {{ Auth::user()->name }}
                </h1>
                <p class="text-white/60 font-semibold text-xl mt-1">
                    Bergabung {{ Auth::user()->created_at->format('M Y') }}
                </p>
            </div>
        </div>

        <!-- Form Content -->
        <div class="space-y-8">
            <!-- Personal Info Section -->
            <div class="bg-white p-6 rounded-2xl shadow-[0_4px_24px_rgba(0,0,0,0.05)]">
                <div class="flex items-center gap-3 pb-6 border-b border-gray-100">
                    <div class="w-9 h-9 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-circle text-blue-600"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-800">Informasi Pribadi</h2>
                </div>

                <div class="space-y-6 pt-6">
                    <!-- Name Field -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <div
                            class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-200 hover:border-blue-400 transition-colors">
                            <div
                                class="w-10 h-10 bg-white rounded-lg border border-gray-200 flex items-center justify-center">
                                <i class="fas fa-user text-gray-500"></i>
                            </div>
                            <input type="text" value="Prof. Milton Konopelski"
                                class="w-full bg-transparent focus:outline-none placeholder-gray-400">
                        </div>
                    </div>

                    <!-- Phone Field -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                        <div
                            class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-200 hover:border-blue-400 transition-colors">
                            <div
                                class="w-10 h-10 bg-white rounded-lg border border-gray-200 flex items-center justify-center">
                                <i class="fas fa-phone text-gray-500"></i>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-gray-500 font-medium">+62</span>
                                <input type="tel" value="85780587569" pattern="[0-9]{9,13}"
                                    class="w-full bg-transparent focus:outline-none">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Security Section -->
            <div class="bg-white p-6 rounded-2xl shadow-[0_4px_24px_rgba(0,0,0,0.05)]">
                <div class="flex items-center gap-3 pb-6 border-b border-gray-100">
                    <div class="w-9 h-9 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-shield-alt text-green-600"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-800">Keamanan Akun</h2>
                </div>

                <div class="space-y-6 pt-6">
                    <!-- Email Field -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Email</label>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-200">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-white rounded-lg border border-gray-200 flex items-center justify-center">
                                    <i class="fas fa-envelope text-gray-500"></i>
                                </div>
                                <span class="font-medium">scot47@example.net</span>
                            </div>
                            <span
                                class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm flex items-center gap-1">
                                <i class="fas fa-check-circle"></i>
                                Terverifikasi
                            </span>
                        </div>
                    </div>

                    <!-- Password Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                            <div
                                class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-200 hover:border-blue-400 transition-colors">
                                <div
                                    class="w-10 h-10 bg-white rounded-lg border border-gray-200 flex items-center justify-center">
                                    <i class="fas fa-lock text-gray-500"></i>
                                </div>
                                <input type="password" class="w-full bg-transparent focus:outline-none"
                                    placeholder="••••••••">
                                <button type="button" class="text-gray-400 hover:text-blue-600 transition-colors"
                                    x-data="{ show: false }" @click="show = !show">
                                    <i class="fas" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                            <div
                                class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-200 hover:border-blue-400 transition-colors">
                                <div
                                    class="w-10 h-10 bg-white rounded-lg border border-gray-200 flex items-center justify-center">
                                    <i class="fas fa-lock text-gray-500"></i>
                                </div>
                                <input type="password" class="w-full bg-transparent focus:outline-none"
                                    placeholder="••••••••">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col-reverse sm:flex-row gap-4 pt-8 justify-end">
                <button
                    class="w-full sm:w-auto px-6 py-3 bg-white text-gray-700 rounded-xl border border-gray-200 hover:bg-gray-50 transition-colors shadow-sm">
                    Batalkan
                </button>
                <button
                    class="w-full sm:w-auto px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors shadow-lg shadow-blue-100 flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </div>
@endsection
