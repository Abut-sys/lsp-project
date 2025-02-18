<x-filament::page>
    <div class="grid grid-cols-1 gap-6">
        <!-- Statistik Utama -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Card Total Kamar -->
            <a href="{{ route('filament.admin.resources.rooms.index') }}">
                <div
                    class="p-6 bg-gradient-to-br from-indigo-600 to-indigo-800 text-white shadow-xl rounded-xl flex items-center space-x-4 transition-transform transform hover:scale-105 hover:shadow-2xl">
                    <div class="p-4 bg-white/20 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16h6m-9 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold">Total Kamar</h3>
                        <p class="text-4xl font-bold">{{ $totalRooms }}</p>
                    </div>
                </div>
            </a>

            <!-- Card Total Booking -->
            <a href="{{ route('filament.admin.resources.bookings.index') }}">
                <div
                    class="p-6 bg-gradient-to-br from-green-500 to-green-700 text-white shadow-xl rounded-xl flex items-center space-x-4 transition-transform transform hover:scale-105 hover:shadow-2xl">
                    <div class="p-4 bg-white/20 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold">Total Booking</h3>
                        <p class="text-4xl font-bold">{{ $totalBookings }}</p>
                    </div>
                </div>
            </a>

            <!-- Card Total Tamu -->
            <div
                class="p-6 bg-gradient-to-br from-yellow-500 to-orange-600 text-white shadow-xl rounded-xl flex items-center space-x-4 transition-transform transform hover:scale-105 hover:shadow-2xl">
                <div class="p-4 bg-white/20 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 17.804A4 4 0 018 16h8a4 4 0 012.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold">Total Tamu</h3>
                    <p class="text-4xl font-bold">{{ $totalGuests }}</p>
                </div>
            </div>
        </div>

        <!-- Diagram -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Grafik Booking (Line Chart) -->
            <div class="bg-gray-800 p-6 rounded shadow">
                <h2 class="text-xl font-bold text-white mb-4">Booking ({{ now()->year }})</h2>
                <div class="w-full h-96">
                    <canvas id="bookingChart" class="w-full h-full"></canvas>
                </div>
            </div>

            <!-- Diagram Total Tamu (Pie Chart) -->
            <div class="bg-gray-800 p-6 rounded shadow">
                <h2 class="text-xl font-bold text-white mb-4">Total Tamu ({{ now()->year }})</h2>
                <div class="w-full h-96">
                    <canvas id="guestChart" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>

        <!-- Tabel Detail Booking (Semua Data) -->
        <div class="bg-gray-800 p-6 rounded shadow">
            <h2 class="text-xl font-bold text-white mb-4">Detail Booking</h2>
            <div class="overflow-y-auto w-full" style="max-height: 400px;">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-indigo-600">
                            <th class="px-6 py-3 text-left text-xm font-bold text-white uppercase tracking-wider">No.
                            </th>
                            <th class="px-6 py-3 text-left text-xm font-bold text-white uppercase tracking-wider">Nama
                            </th>
                            <th class="px-6 py-3 text-left text-xm font-bold text-white uppercase tracking-wider">
                                Email</th>
                            <th class="px-6 py-3 text-left text-xm font-bold text-white uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xm font-bold text-white uppercase tracking-wider">
                                Tanggal Booking</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-700">
                        @foreach ($detailBookings as $booking)
                            <tr class="hover:bg-gray-600">
                                <td class="px-6 py-4 border-t border-gray-600 text-sm text-white">{{ $loop->iteration }}
                                </td>
                                <td class="px-6 py-4 border-t border-gray-600 text-sm text-white">
                                    {{ $booking->user->name ?? '-' }}</td>
                                <td class="px-6 py-4 border-t border-gray-600 text-sm text-white">
                                    {{ $booking->user->email ?? '-' }}</td>
                                <td class="px-6 py-4 border-t border-gray-600 text-sm">
                                    @if ($booking->status === 'confirmed')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full text-white"
                                            style="background-color: #16a34a !important;">Confirmed</span>
                                    @elseif($booking->status === 'pending')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full text-white"
                                            style="background-color: #facc15 !important;">Pending</span>
                                    @elseif($booking->status === 'cancelled')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full text-white"
                                            style="background-color: #dc2626 !important;">Cancelled</span>
                                    @else
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full text-white"
                                            style="background-color: #374151 !important;">{{ ucfirst($booking->status) }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 border-t border-gray-600 text-sm text-white">
                                    {{ $booking->created_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    @push('scripts')
        <!-- Sertakan Chart.js dari CDN -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Grafik Booking (Line Chart) dengan warna hijau
            const ctxBooking = document.getElementById('bookingChart').getContext('2d');
            new Chart(ctxBooking, {
                type: 'line',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Booking',
                        data: @json($chartData),
                        backgroundColor: 'rgba(22, 163, 74, 0.5)', // Hijau dengan opacity 0.5
                        borderColor: 'rgba(22, 163, 74, 1)', // Hijau solid
                        fill: true,
                        tension: 0.4,
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: 'white'
                            }
                        },
                        x: {
                            ticks: {
                                color: 'white'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                color: 'white'
                            }
                        }
                    }
                }
            });

            // Diagram Total Tamu (Pie Chart)
            const ctxGuest = document.getElementById('guestChart').getContext('2d');
            new Chart(ctxGuest, {
                type: 'pie',
                data: {
                    labels: @json($guestChartLabels),
                    datasets: [{
                        label: 'Total Tamu',
                        data: @json($guestChartData),
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(54, 162, 235, 0.65)',
                            'rgba(255, 99, 132, 0.65)',
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 99, 132, 0.6)',
                            'rgba(54, 162, 235, 0.55)',
                            'rgba(255, 99, 132, 0.55)',
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(255, 99, 132, 0.5)',
                            'rgba(54, 162, 235, 0.45)',
                            'rgba(255, 99, 132, 0.45)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1,
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                color: 'white'
                            }
                        }
                    }
                }
            });
        </script>
    @endpush
</x-filament::page>
