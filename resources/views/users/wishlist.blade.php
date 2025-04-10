@extends('layouts.profile')

@section('title', 'Wishlist - ' . Auth::user()->name)

@section('content')
    <div class="space-y-8">
        <div class="text-center">
            <h1
                class="text-4xl font-bold text-gray-900 bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600 inline-block">
                Wishlist Favorit Anda
            </h1>
            <p class="mt-2 text-gray-600">Koleksi kamar impian yang ingin Anda nikmati</p>
        </div>

        @if ($wishlistedRooms->isEmpty())
            <div class="flex flex-col items-center justify-center h-96 space-y-4">
                <div class="bg-gradient-to-r from-blue-100 to-indigo-100 p-8 rounded-full">
                    <i class="fa-solid fa-heart-crack text-6xl text-blue-600"></i>
                </div>
                <p class="text-xl text-gray-600">Wishlist Anda masih kosong</p>
                <a href="{{ route('welcome.home') }}"
                    class="bg-blue-600 text-white px-6 py-2 rounded-full hover:bg-blue-700 transition-all
                  transform hover:scale-105 shadow-lg hover:shadow-blue-200">
                    Jelajahi Kamar
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($wishlistedRooms as $wishlist)
                    <div
                        class="group relative bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all
                    duration-300 overflow-hidden hover:-translate-y-2">

                        <!-- Tombol Hapus Wishlist -->
                        <div class="absolute top-4 right-4 z-10">
                            <button onclick="removeWishlist(this, {{ $wishlist->id }})"
                                class="p-2 bg-gradient-to-br from-red-500 to-pink-500 rounded-full shadow-lg
                           hover:from-red-600 hover:to-pink-600 transition-all transform
                           hover:scale-110 group-hover:opacity-100 opacity-90"
                                title="Hapus dari Wishlist">
                                <i class="fas fa-heart text-white text-xl"></i>
                            </button>
                        </div>

                        <!-- Image Container -->
                        <div class="h-48 overflow-hidden relative">
                            <img src="{{ !empty($wishlist->room->images) ? Storage::url($wishlist->room->images[0]) : asset('default-hotel.jpg') }}"
                                alt="Room Image"
                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                        </div>

                        <!-- Content -->
                        <div class="p-5 space-y-4">
                            <div class="space-y-2">
                                <h3 class="text-xl font-bold text-gray-900">
                                    {{ $wishlist->room->roomType->name }}
                                </h3>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fa-solid fa-door-open mr-2"></i>
                                    No. {{ $wishlist->room->room_number }}
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fa-solid fa-users mr-2"></i>
                                    {{ $wishlist->room->capacity }} Orang
                                </div>
                            </div>

                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-lg font-bold text-blue-600">
                                        Rp {{ number_format($wishlist->room->price, 0, ',', '.') }}
                                        <span class="text-sm font-normal text-gray-500">/malam</span>
                                    </p>
                                </div>
                                <a href="{{ route('room.show', ['roomNumber' => $wishlist->room->room_number]) }}"
                                    class="bg-gradient-to-r from-blue-500 to-indigo-500 text-white px-4 py-2
                               rounded-full text-sm font-semibold transition-all transform
                               hover:scale-105 hover:shadow-lg">
                                    Pesan Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <style>
        .animate-remove {
            animation: removeAnimation 0.5s ease-out forwards;
        }

        @keyframes removeAnimation {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(0.8);
                opacity: 0.5;
            }

            100% {
                transform: scale(0.5);
                opacity: 0;
                display: none;
            }
        }
    </style>

    <script>
        function removeWishlist(button, wishlistId) {
            fetch(`/wishlist/remove/${wishlistId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'removed') {
                        const card = button.closest('.group');
                        card.classList.add('animate-remove');
                        setTimeout(() => card.remove(), 500);

                        // Update counter
                        const counter = card.querySelector('.fa-heart').nextElementSibling;
                        if (counter) {
                            const newCount = parseInt(counter.textContent) - 1;
                            counter.textContent = newCount > 0 ? newCount : '';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menghapus dari wishlist');
                });
        }
    </script>
@endsection
