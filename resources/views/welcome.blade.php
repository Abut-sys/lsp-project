<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BookNStay - Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .parallax {
            perspective: 1px;
            height: 100vh;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .parallax__layer {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }

        @keyframes fade {
            0% {
                opacity: 0.8;
            }

            20% {
                opacity: 1;
            }

            80% {
                opacity: 1;
            }

            100% {
                opacity: 0.8;
            }
        }

        /* Animasi slide */
        .slide-enter-active {
            transition: all 0.3s ease-out;
        }

        .slide-leave-active {
            transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
        }

        .slide-enter-from,
        .slide-leave-to {
            transform: translateX(20px);
            opacity: 0;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-50">
    <x-__navbar />

    <!-- Hero Section -->
    <header class="parallax min-h-[80vh] flex items-center relative overflow-hidden">
        <!-- Background Slides -->
        <div class="absolute inset-0 z-0" x-data="{
            currentSlide: 0,
            slides: [
                '{{ asset('assets/images/allhotel.jpg') }}',
                '{{ asset('assets/images/indor.jpg') }}',
            ],
            autoSlideInterval: null,
            init() {
                this.startAutoSlide();
            },
            startAutoSlide() {
                this.autoSlideInterval = setInterval(() => {
                    this.next();
                }, 5000);
            },
            stopAutoSlide() {
                clearInterval(this.autoSlideInterval);
            },
            next() {
                this.currentSlide = (this.currentSlide + 1) % this.slides.length;
            },
            prev() {
                this.currentSlide = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
            }
        }" @mouseenter="stopAutoSlide()"
            @mouseleave="startAutoSlide()">
            <!-- Slide Images -->
            <template x-for="(slide, index) in slides" :key="index">
                <div class="absolute inset-0 bg-cover bg-center transition-all duration-1000 ease-in-out"
                    :class="currentSlide === index ? 'opacity-100 z-10' : 'opacity-0 z-0'"
                    :style="'background-image: url(' + slide + ')'">
                </div>
            </template>

            <!-- Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-r from-blue-900/80 to-indigo-900/80 z-20"></div>

            <!-- Navigation Dots -->
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-30 flex space-x-2">
                <template x-for="(slide, index) in slides" :key="index">
                    <button @click="currentSlide = index" class="w-3 h-3 rounded-full transition-all duration-300"
                        :class="currentSlide === index ? 'bg-white w-6' : 'bg-white/50'">
                    </button>
                </template>
            </div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl mx-auto text-center" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">
                <!-- Judul dengan animasi lebih halus -->
                <h1 class="text-5xl md:text-6xl font-bold text-white mb-6 transform transition-all duration-700"
                    :class="loaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'">
                    <span class="inline-block hover:text-blue-300 transition-all duration-300">Temukan</span>
                    <span
                        class="text-gradient bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">Penginapan
                        Ideal</span>
                    <div class="text-xl mt-4 font-normal opacity-90">Untuk Perjalanan Terbaik Anda</div>
                </h1>

                <!-- Form dengan animasi floating -->
                <form method="GET" action="{{ route('welcome.home') }}"
                    class="bg-white/90 backdrop-blur-sm rounded-2xl p-6 shadow-2xl transition-all duration-500 hover:shadow-3xl hover:-translate-y-2"
                    :class="loaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-24'">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Room Type dengan preview gambar -->
                        <div x-data="{ open: false, selectedRoomType: '{{ request('query') }}' }" class="relative">
                            <button type="button" @click="open = !open"
                                class="w-full px-4 py-3 text-left bg-white border-2 border-blue-100 rounded-xl hover:border-blue-400 transition-all flex items-center">
                                <span class="flex-1 text-left">
                                    <span class="text-gray-400 text-sm block">Tipe Kamar</span>
                                    <span x-text="selectedRoomType || 'Pilih tipe kamar'" class="font-medium"></span>
                                </span>
                                <i class="fas fa-chevron-down ml-2 text-blue-400 transition-transform"
                                    :class="open ? 'rotate-180' : ''"></i>
                            </button>

                            <div x-show="open" x-cloak @click.away="open = false"
                                class="absolute z-20 w-full mt-2 bg-white rounded-xl shadow-xl border border-blue-50">
                                <div class="max-h-96 overflow-y-auto p-2">
                                    <div class="grid gap-2">
                                        <button type="button" @click="selectedRoomType = ''; open = false"
                                            class="p-3 text-left rounded-lg hover:bg-blue-50 flex items-center space-x-3">
                                            <div
                                                class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                                🏨</div>
                                            <span>Semua Tipe Kamar</span>
                                        </button>
                                        @foreach ($roomTypes as $id => $name)
                                            <button type="button"
                                                @click="selectedRoomType = '{{ $name }}'; open = false"
                                                class="p-3 text-left rounded-lg hover:bg-blue-50 flex items-center space-x-3">
                                                <div
                                                    class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                                    @if (isset($roomTypeImages[$id]))
                                                        <img src="{{ $roomTypeImages[$id] }}"
                                                            class="w-6 h-6 object-cover">
                                                    @else
                                                        🛏
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="font-medium">{{ $name }}</div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $roomTypeDescriptions[$id] ?? '' }}</div>
                                                </div>
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="query" x-model="selectedRoomType">
                        </div>

                        <div x-data="{
                            checkIn: '{{ request('check_in') }}',
                            checkOut: '{{ request('check_out') }}',
                            picker: null,

                            init() {
                                const dateFormat = 'Y-m-d';
                                const self = this;

                                this.picker = flatpickr(this.$refs.dates, {
                                    mode: 'range',
                                    dateFormat: dateFormat,
                                    minDate: 'today',
                                    defaultDate: this.checkIn && this.checkOut ? [this.checkIn, this.checkOut] : null,
                                    onChange: function(selectedDates) {
                                        if (selectedDates.length === 2) {
                                            self.checkIn = flatpickr.formatDate(selectedDates[0], dateFormat);
                                            self.checkOut = flatpickr.formatDate(selectedDates[1], dateFormat);
                                        }
                                    }
                                });

                                this.$watch('checkIn', value => {
                                    if (value && this.checkOut && new Date(value) >= new Date(this.checkOut)) {
                                        this.clearDates();
                                    }
                                });
                            },

                            clearDates() {
                                this.checkIn = '';
                                this.checkOut = '';
                                this.picker.clear();
                                this.updateURL();
                            },

                            updateURL() {
                                const url = new URL(window.location.href);
                                url.searchParams.delete('check_in');
                                url.searchParams.delete('check_out');
                                window.history.replaceState({}, '', url.toString());
                            },

                            formattedDate(date) {
                                return date ? new Date(date).toLocaleDateString('id-ID', {
                                    day: 'numeric',
                                    month: 'long',
                                    year: 'numeric'
                                }) : '';
                            }
                        }" class="relative">
                            <input type="hidden" name="check_in" x-model="checkIn">
                            <input type="hidden" name="check_out" x-model="checkOut">

                            <div class="cursor-pointer bg-white rounded-xl border border-gray-200 hover:border-blue-400 transition-all shadow-sm hover:shadow-md">
                                <div class="flex items-center h-16 px-4" x-ref="dates">
                                    <div class="flex-1 pr-4">
                                        <div class="text-sm font-semibold text-blue-600">CHECK-IN</div>
                                        <div class="text-gray-600"
                                            x-text="checkIn ? formattedDate(checkIn) : 'Pilih tanggal'"></div>
                                    </div>

                                    <div class="h-8 w-px bg-gray-200 mx-2"></div>

                                    <div class="flex-1 pl-4">
                                        <div class="text-sm font-semibold text-blue-600">CHECK-OUT</div>
                                        <div class="text-gray-600"
                                            x-text="checkOut ? formattedDate(checkOut) : 'Pilih tanggal'"></div>
                                    </div>

                                    <div class="ml-4 flex items-center gap-2">
                                        <button x-show="checkIn || checkOut" @click="clearDates()"
                                            class="text-red-400 hover:text-red-600 transition-colors p-1" type="button"
                                            title="Hapus filter tanggal">
                                            <i class="fas fa-times-circle text-lg"></i>
                                        </button>
                                        <div class="text-blue-400">
                                            <i class="fas fa-calendar-alt text-lg"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Guest Selector dengan visual interaktif -->
                        <div x-data="{
                            open: false,
                            guests: {{ request('guests') ?? 'null' }},
                            rooms: {{ request('rooms') ?? 'null' }},
                            updateValue(type, operation) {
                                if (type === 'guests') {
                                    this.guests = Math.max(0, operation === 'minus' ? (this.guests || 0) - 1 : (this.guests || 0) + 1);
                                } else {
                                    this.rooms = Math.max(0, operation === 'minus' ? (this.rooms || 0) - 1 : (this.rooms || 0) + 1);
                                }
                            }
                        }" class="relative">
                            <button type="button" @click="open = !open"
                                class="w-full px-4 py-3 text-left bg-white border-2 border-blue-100 rounded-xl hover:border-blue-400 transition-all flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="bg-blue-100 p-2 rounded-lg">
                                        <i class="fas fa-users text-blue-500"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm text-gray-400">Tamu & Kamar</div>
                                        <div class="font-medium">
                                            <span x-text="guests ?? 'Any'"></span> Tamu •
                                            <span x-text="rooms ?? 'Any'"></span> Kamar
                                        </div>
                                    </div>
                                </div>
                                <i class="fas fa-chevron-down text-blue-400"></i>
                            </button>

                            <div x-show="open" x-cloak @click.away="open = false"
                                class="absolute z-20 w-full mt-2 p-4 bg-white rounded-xl shadow-xl border border-blue-50 space-y-4">
                                <!-- Input Kamar -->
                                <div class="flex items-center justify-between group">
                                    <div class="flex-1">
                                        <div class="font-medium text-gray-700">Kamar</div>
                                        <div class="text-sm text-gray-400">Jumlah kamar yang dibutuhkan</div>
                                    </div>
                                    <div
                                        class="flex items-center gap-2 bg-gray-50 p-2 rounded-lg transition-all duration-300 hover:bg-blue-50">
                                        <button type="button" @click="updateValue('rooms', 'minus')"
                                            :disabled="!rooms || rooms <= 0"
                                            class="w-9 h-9 rounded-full bg-white shadow-sm flex items-center justify-center transition-all
                                                   hover:bg-blue-100 hover:shadow-md
                                                   disabled:opacity-50 disabled:hover:bg-white disabled:cursor-not-allowed">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 12H4" />
                                            </svg>
                                        </button>

                                        <input type="number" name="rooms" x-model="rooms" min="0"
                                            placeholder="0"
                                            class="w-16 text-center text-lg font-semibold bg-transparent border-b-2 border-blue-100
                                                   focus:border-blue-500 focus:outline-none focus:ring-0 transition-colors
                                                   [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none
                                                   [&::-webkit-inner-spin-button]:appearance-none">

                                        <button type="button" @click="updateValue('rooms', 'plus')"
                                            class="w-9 h-9 rounded-full bg-white shadow-sm flex items-center justify-center transition-all
                                                   hover:bg-blue-100 hover:shadow-md">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                        </button>

                                        <button type="button" @click="rooms = ''" x-show="rooms"
                                            class="w-9 h-9 rounded-full flex items-center justify-center text-red-500
                                                   hover:bg-red-50 transition-colors"
                                            title="Clear">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Input Tamu -->
                                <div class="flex items-center justify-between group">
                                    <div class="flex-1">
                                        <div class="font-medium text-gray-700">Tamu</div>
                                        <div class="text-sm text-gray-400">Jumlah Kapasitas</div>
                                    </div>
                                    <div
                                        class="flex items-center gap-2 bg-gray-50 p-2 rounded-lg transition-all duration-300 hover:bg-blue-50">
                                        <button type="button" @click="updateValue('guests', 'minus')"
                                            :disabled="!guests || guests <= 0"
                                            class="w-9 h-9 rounded-full bg-white shadow-sm flex items-center justify-center transition-all
                                                   hover:bg-blue-100 hover:shadow-md
                                                   disabled:opacity-50 disabled:hover:bg-white disabled:cursor-not-allowed">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 12H4" />
                                            </svg>
                                        </button>

                                        <input type="number" name="guests" x-model="guests" min="0"
                                            placeholder="0"
                                            class="w-16 text-center text-lg font-semibold bg-transparent border-b-2 border-blue-100
                                                   focus:border-blue-500 focus:outline-none focus:ring-0 transition-colors
                                                   [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none
                                                   [&::-webkit-inner-spin-button]:appearance-none">

                                        <button type="button" @click="updateValue('guests', 'plus')"
                                            class="w-9 h-9 rounded-full bg-white shadow-sm flex items-center justify-center transition-all
                                                   hover:bg-blue-100 hover:shadow-md">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                        </button>

                                        <button type="button" @click="guests = ''" x-show="guests"
                                            class="w-9 h-9 rounded-full flex items-center justify-center text-red-500
                                                   hover:bg-red-50 transition-colors"
                                            title="Clear">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status Filter dengan indikator visual -->
                        <div x-data="{ isOpen: false, selected: '{{ request('is_available') ?? '' }}' }" class="relative">
                            <input type="hidden" name="is_available" x-model="selected">
                            <button @click="isOpen = !isOpen" type="button"
                                class="w-full h-full px-4 py-3 text-left bg-white border-2 border-blue-100 rounded-xl hover:border-blue-400 transition-all flex items-center space-x-3">
                                <div class="bg-blue-100 p-2 rounded-lg">
                                    <template x-if="selected === ''">
                                        <i class="fas fa-filter text-blue-500"></i>
                                    </template>
                                    <template x-if="selected === '1'">
                                        <i class="fas fa-check-circle text-green-500"></i>
                                    </template>
                                    <template x-if="selected === '0'">
                                        <i class="fas fa-times-circle text-red-500"></i>
                                    </template>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-400">Status Kamar</div>
                                    <div class="font-medium">
                                        <span
                                            x-text="
                                        selected === '1' ? 'Tersedia' :
                                        selected === '0' ? 'Tidak Tersedia' : 'Semua Status'
                                    "></span>
                                    </div>
                                </div>
                            </button>

                            <div x-show="isOpen" x-cloak @click.away="isOpen = false"
                                class="absolute z-20 w-full mt-2 bg-white rounded-xl shadow-xl border border-blue-50">
                                <ul class="p-2 space-y-1">
                                    <li>
                                        <button type="button" @click="selected = ''; isOpen = false"
                                            class="w-full px-4 py-3 rounded-lg hover:bg-blue-50 flex items-center space-x-3">
                                            <i class="fas fa-filter text-gray-500"></i>
                                            <span>Semua Status</span>
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" @click="selected = '1'; isOpen = false"
                                            class="w-full px-4 py-3 rounded-lg hover:bg-green-50 flex items-center space-x-3">
                                            <i class="fas fa-check-circle text-green-500"></i>
                                            <span class="text-green-700">Tersedia</span>
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" @click="selected = '0'; isOpen = false"
                                            class="w-full px-4 py-3 rounded-lg hover:bg-red-50 flex items-center space-x-3">
                                            <i class="fas fa-times-circle text-red-500"></i>
                                            <span class="text-red-700">Tidak Tersedia</span>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                        class="mt-6 w-full bg-gradient-to-r from-blue-500 to-purple-500 text-white py-4 rounded-xl font-bold hover:shadow-lg hover:scale-[1.02] transition-all flex items-center justify-center space-x-3">
                        <i class="fas fa-search animate-pulse"></i>
                        <span>Temukan Kamar Sekarang</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Room List Section -->
    <section class="container mx-auto py-16 px-4" x-data="{ sortBy: '{{ request('sort_by', 'price') }}' }">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">
                Jelajahi Kamar <span class="text-blue-600">Unggulan</span>
            </h2>
            <p class="text-gray-600">Temukan akomodasi terbaik untuk perjalanan Anda</p>
        </div>

        <!-- Sorting Controls -->
        <div class="flex flex-wrap gap-4 mb-8 justify-center">
            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'price']) }}"
                class="px-6 py-2 rounded-full transition-all {{ $sortBy === 'price' ? 'bg-blue-600 text-white shadow-lg' : 'bg-white text-gray-600 shadow-md hover:shadow-lg' }}">
                💰 Harga Terendah
            </a>
            <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'kamar_terbaik']) }}"
                class="px-6 py-2 rounded-full transition-all {{ $sortBy === 'kamar_terbaik' ? 'bg-blue-600 text-white shadow-lg' : 'bg-white text-gray-600 shadow-md hover:shadow-lg' }}">
                🏆 Kamar Terbaik
            </a>
        </div>

        <!-- Room Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($hotels as $room)
                <div
                    class="room-card bg-white rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300
                      transform hover:-translate-y-2 group relative {{ !$room->is_available ? 'opacity-75' : '' }}">
                    <!-- Image Container dengan Overflow Hidden -->
                    <div class="relative overflow-hidden">
                        <img src="{{ $room->images && count($room->images) > 0 ? Storage::url($room->images[0]) : asset('storage/rooms/kamar-ngewe.jpg') }}"
                            class="room-image w-full h-64 object-cover transition-transform duration-500 group-hover:scale-105">

                        <!-- Overlay Gradient -->
                        <div class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black/60">
                            <h3 class="text-xl font-bold text-white">{{ $room->roomType->name }}</h3>
                            <p class="text-blue-200">No. {{ $room->room_number }}</p>
                        </div>

                        <!-- Wishlist Button dengan Animasi -->
                        @auth
                            <button onclick="toggleWishlist(this, {{ $room->id }})"
                                class="absolute top-4 right-4 text-2xl transition-all duration-300
                               hover:scale-125 hover:text-red-500 active:scale-150">
                                <i
                                    class="{{ $room->isWishlistedByUser(auth()->user()) ? 'fa-solid text-red-500 animate-heartbeat' : 'fa-regular text-white' }} fa-heart"></i>
                            </button>
                        @endauth
                    </div>

                    <!-- Card Content -->
                    <div class="p-6">
                        <!-- Header dengan Status Animasi -->
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <p class="text-lg font-bold text-blue-600">
                                    Rp {{ number_format($room->price, 0, ',', '.') }}<span
                                        class="text-sm text-gray-500">/malam</span>
                                </p>
                                <!-- Rating Stars dengan Glow -->
                                <div class="flex items-center mt-2">
                                    <div class="flex text-yellow-400 [&>svg]:hover:scale-125 [&>svg]:transition-all">
                                        @for ($i = 0; $i < 5; $i++)
                                            <svg class="w-5 h-5 fill-current {{ $i < 4.5 ? 'text-yellow-400' : 'text-gray-300' }}"
                                                viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="ml-2 text-gray-600">4.5/5</span>
                                </div>
                            </div>

                            <!-- Status Badge dengan Animasi -->
                            <span class="status-badge {{ $room->is_available ? 'available pulse' : 'booked' }}"
                                title="{{ $room->is_available ? 'Ruangan tersedia' : 'Ruangan tidak tersedia' }}">
                                <i class="fas {{ $room->is_available ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                {{ $room->is_available ? 'Tersedia' : 'Tidak Tersedia' }}
                            </span>
                        </div>

                        <!-- Description -->
                        <p class="text-gray-600 mb-4">{{ Str::limit($room->description, 100) }}</p>

                        <!-- Footer dengan Animasi Button -->
                        <div class="flex justify-between items-center">
                            <div class="flex items-center text-gray-500 hover:text-gray-700 transition-colors">
                                <i class="fas fa-user-friends mr-2"></i>
                                {{ $room->capacity }} Orang
                            </div>
                            <a href="{{ route('room.show', ['roomNumber' => $room->room_number]) }}"
                                class="{{ $room->is_available
                                    ? 'bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800'
                                    : 'bg-gradient-to-r from-yellow-600 to-yellow-700 hover:from-yellow-700 hover:to-yellow-800' }}
                                    text-white px-6 py-2 rounded-full transition-all flex items-center group/button hover:shadow-lg">
                                <span>{{ $room->is_available ? 'Pesan Sekarang' : 'Lihat Detail' }}</span>
                                <i
                                    class="fas fa-arrow-right ml-2 text-sm transform group-hover/button:translate-x-1 transition-transform duration-300"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Hover Overlay Effect -->
                    <div
                        class="absolute inset-0 border-2 border-blue-200/30 rounded-2xl opacity-0
                          group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="inline-block p-8 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow">
                        <i class="fas fa-hotel text-6xl text-blue-500 mb-4 animate-float"></i>
                        <p class="text-xl text-gray-600">Tidak ada kamar yang tersedia</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($hotels->hasPages())
            <div class="mt-12 px-4">
                <div class="flex flex-wrap justify-center gap-2">
                    {{-- Tombol Previous --}}
                    @if ($hotels->onFirstPage())
                        <span class="px-4 py-2 bg-gray-200 rounded-full text-gray-400">
                            &laquo; Previous
                        </span>
                    @else
                        <a href="{{ $hotels->previousPageUrl() }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-all">
                            &laquo; {{ $hotels->currentPage() == 2 ? 'Back' : 'Previous' }}
                        </a>
                    @endif

                    {{-- Tombol Halaman --}}
                    @foreach ($hotels->getUrlRange(1, $hotels->lastPage()) as $page => $url)
                        @if ($page == $hotels->currentPage())
                            <span class="px-4 py-2 bg-blue-600 text-white rounded-full">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}"
                                class="px-4 py-2 bg-white text-blue-600 rounded-full hover:bg-blue-100 transition-all">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Tombol Next --}}
                    @if ($hotels->hasMorePages())
                        <a href="{{ $hotels->nextPageUrl() }}"
                            class="px-4 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-all">
                            Next &raquo;
                        </a>
                    @else
                        <span class="px-4 py-2 bg-gray-200 rounded-full text-gray-400">Next &raquo;</span>
                    @endif
                </div>

                <p class="text-center mt-4 text-gray-600">
                    Menampilkan {{ $hotels->firstItem() }} - {{ $hotels->lastItem() }} dari total
                    {{ $hotels->total() }} kamar
                </p>
            </div>
        @endif
    </section>

    <x-__footer />

    <script>
        function toggleWishlist(button, roomId) {
            const icon = button.querySelector('i');
            fetch("{{ route('wishlist.toggle') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        room_id: roomId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        icon.classList.toggle('fa-regular');
                        icon.classList.toggle('fa-solid');
                        icon.classList.add('animate-heart');
                        setTimeout(() => icon.classList.remove('animate-heart'), 1000);

                        if (data.action === 'added') {
                            Toastify({
                                text: "Ditambahkan ke wishlist!",
                                duration: 3000,
                                close: true,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "#3B82F6",
                            }).showToast();
                        } else {
                            Toastify({
                                text: "Dihapus dari wishlist",
                                duration: 3000,
                                close: true,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "#EF4444",
                            }).showToast();
                        }
                    }
                });
        }

        document.addEventListener('alpine:init', () => {
            Alpine.data('counter', () => ({
                rooms: '',
                guests: '',

                updateValue(field, operation) {
                    const currentValue = this[field] === '' ? 0 : parseInt(this[field])

                    if (operation === 'plus') {
                        this[field] = currentValue + 1
                        this.$refs[field].classList.add('animate-pop')
                    } else if (operation === 'minus' && currentValue > 0) {
                        this[field] = currentValue - 1
                        this.$refs[field].classList.add('animate-pop')
                    }

                    // Hapus animasi setelah selesai
                    setTimeout(() => {
                        this.$refs[field].classList.remove('animate-pop')
                    }, 300)
                }
            }))
        })
    </script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <style>
        // tailwind.config.js
        module.exports= {
            theme: {
                extend: {
                    colors: {
                        green: {
                            600: '#16a34a'
                        }

                        ,
                        red: {
                            600: '#dc2626'
                        }

                        ,
                        gray: {
                            600: '#4b5563'
                        }
                    }
                }
            }
        }

        .text-gradient {
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .shadow-3xl {
            box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.15);
        }

        /* Custom Animation untuk Heartbeat */
        @keyframes heartbeat {
            0% {
                transform: scale(1);
            }

            25% {
                transform: scale(1.2);
            }

            50% {
                transform: scale(1);
            }

            75% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        .animate-heartbeat {
            animation: heartbeat 1s ease-in-out infinite;
        }

        /* Custom Animation untuk Image Float */
        @keyframes float {
            0% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }

            100% {
                transform: translateY(0);
            }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 2rem;
        }

        .page-item {
            display: inline-block;
        }

        .page-link {
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            transition: all 0.3s ease;
        }

        .page-link:hover {
            transform: translateY(-1px);
        }

        /* Animasi untuk perubahan nilai */
        @keyframes pop {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        .animate-pop {
            animation: pop 0.3s ease-in-out;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            cursor: default;
            gap: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .status-badge i {
            font-size: 1.1em;
        }

        /* Available Style */
        .status-badge.available {
            background: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #a5d6a7;
        }

        .status-badge.available:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(46, 125, 50, 0.2);
        }

        /* Booked Style */
        .status-badge.booked {
            background: #fff3e0;
            color: #ef6c00;
            border: 1px solid #ffcc80;
        }

        .status-badge.booked:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(239, 108, 0, 0.2);
        }

        /* Pulse Animation */
        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.02);
            }

            100% {
                transform: scale(1);
            }
        }

        .pulse {
            animation: pulse 1.5s infinite;
        }
    </style>

</body>

</html>
