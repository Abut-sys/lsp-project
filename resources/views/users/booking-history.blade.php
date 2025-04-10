@extends('layouts.profile')

@section('title', 'Riwayat Pemesanan - ' . Auth::user()->name)

@section('content')
    <div class="space-y-8">
        <div class="text-center">
            <h1
                class="text-4xl font-bold text-gray-900 bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 inline-block">
                Riwayat Perjalanan Anda
            </h1>
            <p class="mt-2 text-gray-600">Catatan semua pengalaman menginap Anda</p>
        </div>

        @if ($bookings->isEmpty())
            <div class="flex flex-col items-center justify-center h-96 space-y-4">
                <div class="bg-gradient-to-r from-blue-100 to-indigo-100 p-8 rounded-full">
                    <i class="fa-solid fa-clock-rotate-left text-6xl text-blue-600"></i>
                </div>
                <p class="text-xl text-gray-600">Belum ada riwayat pemesanan</p>
                <a href="{{ route('welcome.home') }}"
                    class="bg-blue-600 text-white px-6 py-2 rounded-full hover:bg-blue-700 transition-all
                  transform hover:scale-105 shadow-lg hover:shadow-blue-200">
                    Temukan Kamar
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($bookings as $booking)
                    <div
                        class="group relative bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all
                    duration-300 overflow-hidden hover:-translate-y-2">
                        <!-- Image Section -->
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ !empty($booking->room->images) ? Storage::url($booking->room->images[0]) : asset('default-hotel.jpg') }}"
                                alt="Room Image"
                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                        </div>

                        <!-- Content Section -->
                        <div class="p-6 space-y-4">
                            <div class="space-y-2">
                                <h3 class="text-xl font-bold text-gray-900">
                                    {{ $booking->room->roomType->name }}
                                    <span class="text-gray-600">#{{ $booking->room->room_number }}</span>
                                </h3>

                                <div class="flex items-center gap-4 text-sm text-gray-600">
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-calendar-day text-blue-500"></i>
                                        <span>{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <i class="fa-solid fa-calendar-xmark text-red-500"></i>
                                        <span>{{ \Carbon\Carbon::parse($booking->check_out_date)->format('d M Y') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-lg font-bold text-blue-600">
                                        <span class="text-xl font-bold text-gray-500">Total Biaya :</span>
                                        Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div class="flex gap-3">
                                    <a href="{{ route('room.show', $booking->room->room_number) }}"
                                        class="flex items-center gap-2 bg-blue-100 text-blue-600 px-4 py-2 rounded-full
                                  hover:bg-blue-200 transition-all transform hover:scale-105">
                                        <i class="fa-solid fa-circle-info"></i>
                                        <span class="text-sm font-semibold">Detail</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
