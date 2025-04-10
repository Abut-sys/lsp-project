<x-filament::page>
    <div class="grid grid-cols-1 gap-6">
        <!-- Statistik Utama -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Card Total Kamar -->
            <a href="{{ route('filament.admin.resources.rooms.index') }}" class="h-full">
                <div
                    class="h-full p-6 bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm flex flex-col justify-between">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-indigo-100 dark:bg-indigo-900/20 rounded-lg">
                            <svg class="w-10 h-10 text-indigo-600 dark:text-indigo-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16h6m-9 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Kamar</h3>
                            <p class="text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ $totalRooms }}</p>
                        </div>
                    </div>
                    <div class="mt-4 text-xs text-gray-400 dark:text-gray-500">Lihat detail kamar →</div>
                </div>
            </a>

            <!-- Card Reservasi Aktif -->
            <a href="{{ route('filament.admin.resources.bookings.index') }}" class="h-full">
                <div
                    class="h-full p-6 bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm flex flex-col justify-between">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-blue-100 dark:bg-blue-900/20 rounded-lg">
                            <svg class="w-10 h-10 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Reservasi Aktif</h3>
                            <p class="text-3xl font-semibold text-gray-900 dark:text-gray-100">{{ $activeReservations }}
                            </p>
                        </div>
                    </div>
                    <div class="mt-4 text-xs text-gray-400 dark:text-gray-500">Kelola reservasi →</div>
                </div>
            </a>

            <!-- Card Kamar Terpopuler -->
            <div
                class="h-full p-6 bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm flex flex-col justify-between">
                <div class="space-y-5">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Tipe Kamar Terpopuler</h3>
                        <span
                            class="px-2 py-1 bg-green-100 dark:bg-green-900/20 text-green-700 dark:text-green-400 text-xs rounded-full">
                            {{ $popularityPercentage }}%
                        </span>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-amber-100 dark:bg-amber-900/20 rounded-lg">
                                <span class="text-2xl text-amber-600 dark:text-amber-400">⭐</span>
                            </div>
                            <div>
                                <p class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $mostPopularRoomType }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    {{ $bookingCount }} Reservasi • {{ $averageStay }} Malam
                                </p>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div class="h-1.5 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-amber-400 to-amber-500"
                                    style="width: {{ $popularityPercentage }}%">
                                </div>
                            </div>
                            <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400">
                                <span>Popularitas</span>
                                <span>{{ $popularityPercentage }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4 text-xs text-gray-400 dark:text-gray-500">Analisis lengkap →</div>
            </div>
        </div>

        <!-- Card Total Tamu -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Card Total Tamu -->
            <div
                class="group relative bg-gray-50 dark:bg-gray-900 rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300 min-h-[180px] flex items-center justify-center">
                <div class="w-full text-center space-y-4">
                    <!-- Icon (Tetap besar) -->
                    <div class="mx-auto p-4 bg-indigo-100 dark:bg-indigo-900/30 rounded-full w-max">
                        <svg class="w-20 h-20 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>

                    <!-- Konten yang diperkecil -->
                    <div class="space-y-1">
                        <h3 class="text-xl font-medium text-gray-500 dark:text-gray-400">Total Tamu</h3>
                        <p class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $totalGuests }}</p>
                    </div>

                    <!-- Badge yang diperkecil -->
                    <div class="flex justify-center">
                        <span
                            class="inline-flex items-center px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400 text-xs font-medium rounded-full">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M5 10l7-7m0 0l7 7m-7-7v18" />
                            </svg>
                            +12.5%
                        </span>
                    </div>
                </div>
            </div>

            <!-- Diagram Distribusi Tamu -->
            <div class="bg-gray-50 dark:bg-gray-900 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Guest Distribution</h2>
                    <div class="relative">
                        <select class="text-xs bg-transparent border-0 text-gray-500 dark:text-gray-400 focus:ring-0">
                            <option>{{ now()->year }}</option>
                        </select>
                    </div>
                </div>
                <div class="relative">
                    <canvas id="guestChart" class="w-full h-64"></canvas>
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <div class="text-center">
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">100%</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Total Guests</p>
                        </div>
                    </div>
                </div>
                <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
                    <div class="flex items-center">
                        <span class="w-2 h-2 bg-indigo-500 rounded-full mr-2"></span>
                        <span class="text-gray-500 dark:text-gray-400">New Guests</span>
                        <span class="ml-auto font-medium text-gray-900 dark:text-white">65%</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-2 h-2 bg-cyan-400 rounded-full mr-2"></span>
                        <span class="text-gray-500 dark:text-gray-400">Returning</span>
                        <span class="ml-auto font-medium text-gray-900 dark:text-white">35%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Diagram -->
        <div class="md:-mx-8 lg:-mx-12 xl:-mx-16">
            <div class="bg-gray-50 dark:bg-gray-900 md:p-8 lg:p-12 rounded-none shadow-xl">
                <h2 class="text-xl font-bold text-white mb-4">Total Pendapatan ({{ now()->year }})</h2>
                <div class="w-full h-96">
                    <canvas id="revenueBookingChart" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>



        <!-- Tabel Detail Booking (Semua Data) -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="p-6 pb-4">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Detail Booking</h2>
            </div>

            <div class="overflow-y-auto w-full" style="max-height: 400px;">
                <table class="w-full">
                    <thead class="sticky top-0 bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-100 dark:border-gray-600">
                                No.
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-100 dark:border-gray-600">
                                Nama
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-100 dark:border-gray-600">
                                Email
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-100 dark:border-gray-600">
                                Status
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-100 dark:border-gray-600">
                                Tanggal Booking
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach ($detailBookings as $booking)
                        <tr class="dark:hover:bg-transparent">
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-300 font-medium">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                {{ $booking->user->name ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-200">
                                {{ $booking->user->email ?? '-' }}
                            </td>
                            <td class="px-4 py-3">
                                @if ($booking->payment_status === 'confirmed')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400"
                                    title="Payment Status: Confirmed" style="background-color: #16a34a !important;">
                                    Confirmed
                                </span>
                                @elseif($booking->payment_status === 'pending')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400"
                                    title="Payment Status: Pending" style="background-color: #f59e0b !important;">
                                    Pending
                                </span>
                                @elseif($booking->payment_status === 'cancelled')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400"
                                    title="Payment Status: Cancelled" style="background-color: #e3342f !important;">
                                    Cancelled
                                </span>
                                @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-600/30 text-gray-800 dark:text-gray-300">
                                    {{ ucfirst($booking->status) }}
                                </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">
                                {{ $booking->created_at->format('d M Y') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <style>
        .bg-noise {
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)'/%3E%3C/svg%3E");
        }

        .animate-progress-pulse {
            animation: progress-pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes progress-pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }

        .overflow-x-auto::-webkit-scrollbar {
            @apply h-2;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            @apply bg-gray-100 dark:bg-gray-700 rounded-full;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            @apply bg-gray-300 dark:bg-gray-600 rounded-full hover:bg-gray-400 dark:hover:bg-gray-500;
        }
    </style>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
        <script>
            Chart.register(ChartDataLabels);

            // Common configuration
            const chartTheme = {
                fontColor: '#FFF',
                color: 'rgba(255, 255, 255, 0.1)',
                borderColor: 'rgba(255, 255, 255, 0.1)'
            };

            // Gradient generator
            const createGradient = (ctx, color1, color2) => {
                const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, color1);
                gradient.addColorStop(1, color2);
                return gradient;
            };

            // Bar Chart - Revenue & Bookings
            const revenueBookingChart = () => {
                const ctx = document.getElementById('revenueBookingChart').getContext('2d');

                return new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: @json($chartLabels),
                        datasets: [{
                            label: 'Total Pendapatan (Rp)',
                            data: @json($revenueChartData),
                            backgroundColor: createGradient(ctx, 'rgba(76, 175, 80, 0.8)',
                                'rgba(76, 175, 80, 0.2)'),
                            borderColor: '#4CAF50',
                            borderWidth: 0,
                            borderRadius: 12,
                            borderSkipped: false,
                            yAxisID: 'y',
                        }, {
                            label: 'Total Booking',
                            data: @json($chartData),
                            backgroundColor: createGradient(ctx, 'rgba(156, 39, 176, 0.8)',
                                'rgba(156, 39, 176, 0.2)'),
                            borderColor: '#9C27B0',
                            borderWidth: 0,
                            borderRadius: 12,
                            borderSkipped: false,
                            yAxisID: 'y1',
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    color: '#FFF',
                                    font: {
                                        size: 14
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0,0,0,0.8)',
                                titleFont: {
                                    size: 16
                                },
                                bodyFont: {
                                    size: 14
                                },
                                padding: 12,
                                usePointStyle: true,
                                callbacks: {
                                    label: function(context) {
                                        let label = context.dataset.label || '';
                                        if (label) label += ': ';
                                        if (context.parsed.y !== null) {
                                            label += context.dataset.label.includes('Pendapatan') ?
                                                'Rp ' + context.parsed.y.toLocaleString() :
                                                context.parsed.y.toLocaleString();
                                        }
                                        return label;
                                    }
                                }
                            },
                            datalabels: {
                                display: false // Disable for cleaner look
                            }
                        },
                        scales: {
                            y: {
                                type: 'linear',
                                display: true,
                                position: 'left',
                                grid: {
                                    color: chartTheme.borderColor
                                },
                                ticks: {
                                    color: chartTheme.fontColor,
                                    callback: (value) => 'Rp ' + value.toLocaleString()
                                },
                                title: {
                                    display: true,
                                    text: 'Pendapatan',
                                    color: chartTheme.fontColor
                                }
                            },
                            y1: {
                                type: 'linear',
                                display: true,
                                position: 'right',
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: chartTheme.fontColor,
                                    callback: (value) => value.toLocaleString()
                                },
                                title: {
                                    display: true,
                                    text: 'Jumlah Booking',
                                    color: chartTheme.fontColor
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: chartTheme.fontColor,
                                    font: {
                                        size: 12
                                    }
                                }
                            }
                        },
                        interaction: {
                            mode: 'index',
                            intersect: false
                        }
                    }
                });
            };

            // Doughnut Chart - Total Tamu
            const guestChart = () => {
                const ctx = document.getElementById('guestChart').getContext('2d');

                return new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: @json($guestChartLabels),
                        datasets: [{
                            data: @json($guestChartData),
                            backgroundColor: [
                                '#4CAF50', '#9C27B0', '#2196F3',
                                '#FF5722', '#E91E63', '#00BCD4',
                                '#FFC107', '#8BC34A', '#3F51B5',
                                '#CDDC39', '#009688', '#FF9800'
                            ],
                            borderWidth: 0,
                            hoverOffset: 20,
                            spacing: 4
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        cutout: '65%',
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: {
                                    color: chartTheme.fontColor,
                                    font: {
                                        size: 12
                                    },
                                    padding: 20,
                                    usePointStyle: true
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0,0,0,0.8)',
                                bodyFont: {
                                    size: 14
                                },
                                padding: 12,
                                usePointStyle: true
                            },
                            datalabels: {
                                color: '#FFF',
                                font: {
                                    weight: 'bold',
                                    size: (context) =>
                                        context.dataIndex === context.dataset.data.indexOf(Math.max(...context
                                            .dataset.data)) ?
                                        14 : 12
                                },
                                formatter: (value, context) => {
                                    const total = context.dataset.data.reduce((a, b) => a + b);
                                    const percentage = ((value / total) * 100).toFixed(1) + '%';
                                    return percentage;
                                }
                            }
                        },
                        animation: {
                            duration: 1500,
                            easing: 'easeInOutQuart'
                        }
                    }
                });
            };

            // Initialize charts
            document.addEventListener('DOMContentLoaded', () => {
                revenueBookingChart();
                guestChart();
            });
        </script>
    @endpush
</x-filament::page>
