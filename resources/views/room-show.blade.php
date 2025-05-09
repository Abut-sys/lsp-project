@extends('layouts.detail_kamar')

@section('title', 'Detail Kamar - ' . $room->roomType->name . ' | BookNStay')

@section('content')
    <div class="container mx-auto p-4 lg:p-8 pt-16">
        <!-- Judul dengan animasi -->
        <div class="mb-12 text-center animate-fade-in-down">
            <h1
                class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-2">
                🏨 {{ $room->roomType->name }} - No. {{ $room->room_number }}
            </h1>
            <div class="flex items-center justify-center space-x-2">
                <div class="h-px w-16 bg-gradient-to-r from-transparent via-blue-500 to-transparent"></div>
                <span class="text-gray-500 text-sm">Luxury Experience</span>
                <div class="h-px w-16 bg-gradient-to-r from-transparent via-blue-500 to-transparent"></div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Galeri Gambar -->
            <div class="lg:w-1/2">
                <div
                    class="relative group rounded-2xl overflow-hidden shadow-2xl hover:shadow-3xl transition-all duration-300">
                    <div class="aspect-ratio-16/9 overflow-hidden">
                        <img id="mainImage" src="{{ Storage::url($room->images[0]) }}"
                            class="w-full h-96 object-cover transform transition-all duration-500 cursor-zoom-in"
                            data-current-index="0">
                    </div>

                    <!-- Navigation Arrows -->
                    <div
                        class="absolute inset-0 flex items-center justify-between px-4 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button onclick="previousImage()"
                            class="p-3 bg-white/90 backdrop-blur-sm rounded-full shadow-lg hover:bg-white transition-all hover:scale-110">
                            <i class="fas fa-chevron-left text-gray-800 text-xl"></i>
                        </button>
                        <button onclick="nextImage()"
                            class="p-3 bg-white/90 backdrop-blur-sm rounded-full shadow-lg hover:bg-white transition-all hover:scale-110">
                            <i class="fas fa-chevron-right text-gray-800 text-xl"></i>
                        </button>
                    </div>

                    <!-- Image Counter -->
                    <div
                        class="absolute bottom-4 left-1/2 -translate-x-1/2 bg-black/40 text-white px-3 py-1 rounded-full text-sm">
                        <span id="currentImage">1</span>/{{ count($room->images) }}
                    </div>
                </div>

                <!-- Thumbnails Grid -->
                <div class="grid grid-cols-4 gap-3 mt-4">
                    @foreach ($room->images as $key => $image)
                        <div class="relative aspect-square cursor-pointer group" onclick="changeImage({{ $key }})">
                            <img src="{{ Storage::url($image) }}"
                                class="w-full h-full object-cover rounded-xl border-2 transition-all duration-300
                                        {{ $key === 0 ? 'border-blue-500 scale-105' : 'border-transparent' }}
                                        group-hover:border-blue-300 group-hover:scale-105 thumbnail">
                            <div
                                class="absolute inset-0 bg-black/30 group-hover:bg-transparent transition-colors rounded-xl">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Detail Kamar -->
            <div class="lg:w-1/2 space-y-6">
                <!-- Header Info -->
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100">
                    <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-4 gap-4">
                        <div class="space-y-2">
                            <div class="text-2xl font-bold text-blue-600 animate-pulse">
                                Rp {{ number_format($room->price, 0, ',', '.') }}
                                <span class="text-lg text-gray-500 font-normal">/malam</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="flex items-center">
                                    @for ($i = 0; $i < 5; $i++)
                                        <i
                                            class="fas fa-star {{ $i < 4.5 ? 'text-yellow-400' : 'text-gray-300' }} text-sm"></i>
                                    @endfor
                                </div>
                                <span class="text-gray-500 text-sm">(200 ulasan)</span>
                            </div>
                        </div>

                        <button id="wishlistButton"
                            class="p-3 bg-gray-100 hover:bg-red-100 rounded-full transition-colors wishlist-btn">
                            @auth
                                <i
                                    class="{{ $isWishlisted ? 'fas text-red-500 animate-heart-beat' : 'far' }} fa-heart text-2xl"></i>
                            @else
                                <i class="far fa-heart text-2xl text-gray-500"></i>
                            @endauth
                        </button>
                    </div>

                    <!-- Fasilitas -->
                    <div class="grid grid-cols-2 gap-3 mt-4">
                        @foreach ($room->roomType->facilities as $facility)
                            <div
                                class="flex items-center p-3 bg-gray-50 rounded-lg transition-all hover:bg-blue-50 hover:-translate-y-1">
                                <i class="{{ getFacilityIcon($facility) }} text-blue-500 mr-2 text-lg"></i>
                                <div>
                                    <div class="text-sm font-medium">{{ $facility }}</div>
                                    <div class="text-xs text-gray-500">{{ getFacilityDescription($facility) }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100">
                    <h2 class="text-xl font-semibold mb-4 flex items-center">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-2">
                            <i class="fas fa-info-circle text-blue-500"></i>
                        </div>
                        Tentang Kamar Ini
                    </h2>
                    <p class="text-gray-600 leading-relaxed text-justify">
                        {{ $room->description ?? 'Nikmati kenyamanan premium dengan tempat tidur king size, dekorasi modern, dan pemandangan kota yang memukau...' }}
                    </p>
                    <div class="mt-4 grid grid-cols-2 gap-2">
                        <div class="flex items-center">
                            <i class="fas fa-ruler-combined text-gray-400 mr-2"></i>
                            <span class="text-sm">Ukuran Kamar: 35m²</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-bed text-gray-400 mr-2"></i>
                            <span class="text-sm">Tempat Tidur: King Size</span>
                        </div>
                    </div>
                </div>

                <!-- Form Pemesanan -->
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 form-enter">
                    @if ($room->is_available === 0)
                        <div class="bg-red-50 p-4 rounded-lg text-center border border-red-100">
                            <p class="text-red-600 font-semibold flex items-center justify-center gap-2">
                                <i class="fas fa-times-circle"></i>
                                Kamar sedang tidak tersedia
                            </p>
                        </div>
                    @else
                        @guest
                            <div class="text-center py-6 space-y-4">
                                <p class="text-gray-600">Login untuk melanjutkan pemesanan</p>
                                <a href="{{ route('user.login.email') }}"
                                    class="inline-flex items-center bg-gradient-to-r from-blue-500 to-purple-500 text-white px-8 py-3 rounded-full
                                          font-semibold hover:shadow-lg transition-all transform hover:scale-105 gap-2">
                                    <i class="fas fa-sign-in-alt"></i>
                                    Masuk Sekarang
                                </a>
                            </div>
                        @else
                            @if ($userBookings->count() > 0)
                                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4 rounded-lg">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-exclamation-circle text-yellow-600"></i>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-medium text-yellow-700">Booking Aktif Anda:</h3>
                                            <div class="mt-2 text-sm text-yellow-600 space-y-1">
                                                @foreach ($userBookings as $booking)
                                                    <p>
                                                        {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }} -
                                                        {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d M Y') }}
                                                    </p>
                                                @endforeach
                                            </div>
                                            <p class="mt-2 text-xs text-yellow-700">
                                                Anda bisa memesan kamar ini lagi dengan memilih tanggal yang berbeda
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <form action="{{ route('payment.process', $room->id) }}" method="POST" class="space-y-4"
                                id="bookingForm">
                                @csrf

                                <!-- Date Picker -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="relative">
                                        <label class="block text-sm font-medium mb-2">Check-in</label>
                                        <div class="relative">
                                            <input type="text" name="check_in_date" id="check_in_date"
                                                class="w-full p-3 border border-gray-300 rounded-lg
                                                        focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                                                        hover:border-blue-400 transition-all pr-10"
                                                value="{{ old('check_in_date') }}" required readonly>
                                            <i
                                                class="fas fa-calendar-alt absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                        </div>
                                    </div>

                                    <div class="relative">
                                        <label class="block text-sm font-medium mb-2">Check-out</label>
                                        <div class="relative">
                                            <input type="text" name="check_out_date" id="check_out_date"
                                                class="w-full p-3 border border-gray-300 rounded-lg
                                                        focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                                                        hover:border-blue-400 transition-all pr-10"
                                                value="{{ old('check_out_date') }}" required readonly>
                                            <i
                                                class="fas fa-calendar-alt absolute right-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Error Messages -->
                                <div id="dateError" class="text-red-500 text-sm hidden"></div>

                                <!-- Price Calculator -->
                                <div id="priceSummary" class="bg-blue-50 p-4 rounded-lg mt-4 border border-blue-200 hidden">
                                    <div class="space-y-2">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Harga per malam</span>
                                            <span class="font-medium">Rp {{ number_format($room->price, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Durasi Menginap</span>
                                            <span class="font-medium" id="durationDays">0 Malam</span>
                                        </div>
                                        <div class="border-t border-blue-200 my-2"></div>
                                        <div class="flex justify-between items-center">
                                            <span class="font-semibold">Total</span>
                                            <span class="text-xl text-blue-600 font-bold" id="totalPrice"></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tombol Submit -->
                                <button type="submit"
                                    class="w-full bg-gradient-to-r from-green-500 to-blue-500 text-white p-4 rounded-xl
                                               font-semibold hover:shadow-lg transition-all transform hover:scale-[1.02]
                                               flex items-center justify-center gap-2">
                                    <i class="fas fa-concierge-bell animate-bell"></i>
                                    Pesan Sekarang
                                </button>
                            </form>
                        @endguest
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .aspect-ratio-16/9 {
            aspect-ratio: 16 / 9;
        }

        .animate-fade-in-down {
            animation: fadeInDown 0.8s ease-out;
        }

        .animate-heart-beat {
            animation: heartBeat 0.6s cubic-bezier(0.4, 0, 0.6, 1);
        }

        .animate-bell {
            animation: bellRing 1s ease infinite;
        }

        @keyframes fadeInDown {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes heartBeat {
            0% {
                transform: scale(1);
            }

            15% {
                transform: scale(1.3);
            }

            30% {
                transform: scale(0.95);
            }

            45% {
                transform: scale(1.15);
            }

            60% {
                transform: scale(0.98);
            }

            75% {
                transform: scale(1.08);
            }

            90% {
                transform: scale(1);
            }
        }

        @keyframes bellRing {

            0%,
            100% {
                transform: rotate(0deg);
            }

            25% {
                transform: rotate(15deg);
            }

            75% {
                transform: rotate(-15deg);
            }
        }

        .wishlist-btn {
            transition: all 0.3s ease;
            transform-origin: center;
        }

        .wishlist-btn:hover {
            transform: translateY(-2px) scale(1.1);
            filter: drop-shadow(0 4px 6px rgba(239, 68, 68, 0.2));
        }

        input[type="date"]::-webkit-calendar-picker-indicator {
            opacity: 0;
            position: absolute;
            right: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        #mainImage {
            transition: opacity 0.5s ease-in-out, transform 0.3s ease;
        }
    </style>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Galeri Gambar
            let currentIndex = 0;
            const images = @json(collect($room->images)->map(fn($img) => Storage::url($img)));
            const totalImages = images.length;

            function updateMainImage(index) {
                const mainImage = document.getElementById('mainImage');
                const thumbnails = document.querySelectorAll('.thumbnail');

                index = Math.max(0, Math.min(index, totalImages - 1));
                mainImage.style.opacity = 0;
                setTimeout(() => {
                    mainImage.src = images[index];
                    mainImage.dataset.currentIndex = index;
                    mainImage.style.opacity = 1;
                    document.getElementById('currentImage').textContent = index + 1;

                    thumbnails.forEach((thumb, i) => {
                        thumb.classList.toggle('border-blue-500', i === index);
                    });
                }, 300);
            }

            window.nextImage = () => {
                currentIndex = (currentIndex + 1) % totalImages;
                updateMainImage(currentIndex);
            }

            window.previousImage = () => {
                currentIndex = (currentIndex - 1 + totalImages) % totalImages;
                updateMainImage(currentIndex);
            }

            window.changeImage = (index) => {
                currentIndex = index;
                updateMainImage(index);
            }

            // Form Pemesanan
            const checkInInput = document.getElementById('check_in_date');
            const checkOutInput = document.getElementById('check_out_date');
            const dateError = document.getElementById('dateError');
            const existingBookings = @json($existingBookings ?? []);
            // const disabledDates = @json($disabledDates);
            // let checkInPicker, checkOutPicker;


            // Inisialisasi tanggal check-out minimum
            const checkInMinDate = checkInInput.min ? new Date(checkInInput.min) : new Date();
            const initialCheckOutMin = new Date(checkInMinDate);
            initialCheckOutMin.setDate(initialCheckOutMin.getDate() + 1);
            checkOutInput.min = initialCheckOutMin.toISOString().split('T')[0];

            checkInInput.addEventListener('change', () => {
                const checkInDate = new Date(checkInInput.value);
                const minCheckOut = new Date(checkInDate);
                minCheckOut.setDate(minCheckOut.getDate() + 1);

                checkOutInput.min = minCheckOut.toISOString().split('T')[0];

                // Update check-out value jika tidak valid
                if (new Date(checkOutInput.value) < minCheckOut) {
                    checkOutInput.value = minCheckOut.toISOString().split('T')[0];
                }

                calculatePrice();
            });

            checkOutInput.addEventListener('change', calculatePrice);

            // Inisialisasi Flatpickr dengan tanggal yang dinonaktifkan
            var disabledDates = @json($disabledDates);

            // Konfigurasi Flatpickr untuk check-in
            var checkInPicker = flatpickr('#check_in_date', {
                dateFormat: 'Y-m-d',
                minDate: 'today',
                disable: disabledDates,
                onChange: function(selectedDates) {
                    if (selectedDates.length > 0) {
                        // Set minimal check-out satu hari setelah check-in
                        checkOutPicker.set('minDate', selectedDates[0].fp_incr(1));
                        checkOutPicker.clear();
                    }
                    calculatePrice();
                }
            });

            // Konfigurasi Flatpickr untuk check-out
            var checkOutPicker = flatpickr('#check_out_date', {
                dateFormat: 'Y-m-d',
                minDate: new Date().fp_incr(1),
                disable: disabledDates,
                onChange: function() {
                    calculatePrice();
                }
            });

            // Update fungsi validasi
            function validateDates() {
                const checkIn = checkInPicker.selectedDates[0];
                const checkOut = checkOutPicker.selectedDates[0];
                let isValid = true;
                dateError.classList.add('hidden');

                if (!checkIn || !checkOut) return false;

                if (checkIn >= checkOut) {
                    dateError.textContent = 'Tanggal check-out harus setelah check-in';
                    dateError.classList.remove('hidden');
                    isValid = false;
                }

                return isValid;
            }

            function calculatePrice() {
                const checkIn = new Date(checkInInput.value);
                const checkOut = new Date(checkOutInput.value);

                if (checkIn && checkOut && checkOut > checkIn && validateDates()) {
                    const diffTime = checkOut - checkIn;
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                    const totalPrice = diffDays * {{ $room->price }};

                    document.getElementById('durationDays').textContent = `${diffDays} Malam`;
                    document.getElementById('totalPrice').textContent = `Rp ${totalPrice.toLocaleString('id-ID')}`;
                    document.getElementById('priceSummary').classList.remove('hidden');
                } else {
                    document.getElementById('priceSummary').classList.add('hidden');
                }
            }

            document.getElementById('bookingForm').addEventListener('submit', function(e) {
                if (!validateDates()) {
                    e.preventDefault();
                    window.scrollTo({
                        top: dateError.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            });

            // Wishlist
            document.getElementById('wishlistButton').addEventListener('click', function(e) {
                    e.preventDefault();
                    @auth
                    const heartIcon = this.querySelector('i');
                    fetch('{{ route('wishlist.toggle') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                room_id: {{ $room->id }}
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                heartIcon.classList.toggle('fas', data.status);
                                heartIcon.classList.toggle('far', !data.status);
                                heartIcon.classList.toggle('text-red-500', data.status);
                                if (data.status) {
                                    heartIcon.classList.add('animate-heart-beat');
                                    setTimeout(() => heartIcon.classList.remove('animate-heart-beat'),
                                        1000);
                                }
                            }
                        })
                        .catch(() => alert('Terjadi kesalahan'));
                @else
                    window.location.href = '{{ route('user.login.email') }}';
                @endauth
            });

        @if (old('check_in_date') && old('check_out_date'))
            calculatePrice();
        @endif
        });
    </script>


@endsection
