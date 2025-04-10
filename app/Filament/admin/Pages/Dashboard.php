<?php

namespace App\Filament\Admin\Pages;

use App\Models\Room;
use App\Models\User;
use App\Models\Booking;
use App\Models\RoomType;
use Filament\Pages\Page;
use Illuminate\Support\Carbon;
use Filament\Tables\Columns\Concerns\HasWidth;

class Dashboard extends Page
{
    protected static string $view = 'filament.admin.pages.dashboard';
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    public function getViewData(): array
    {
        // Booking Statistics
        $bookings = Booking::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('count', 'month');

        $labels = [];
        $bookingData = [];
        for ($m = 1; $m <= 12; $m++) {
            $labels[] = date('F', mktime(0, 0, 0, $m, 1));
            $bookingData[] = $bookings->get($m, 0);
        }

        // Guest Statistics
        $guests = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->where('role', 'user')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('count', 'month');

        $guestData = [];
        for ($m = 1; $m <= 12; $m++) {
            $guestData[] = $guests->get($m, 0);
        }

        // Revenue Statistics
        $revenues = Booking::selectRaw('MONTH(created_at) as month, SUM(total_price) as revenue')
            ->where('payment_status', 'confirmed')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->pluck('revenue', 'month');

        $revenueChartData = [];
        for ($m = 1; $m <= 12; $m++) {
            $revenueChartData[] = $revenues->get($m, 0);
        }

        // Most Popular Room
        $mostPopularRoomType = RoomType::withCount('bookings')
            ->orderByDesc('bookings_count')
            ->first();

        // Popularity Calculations
        $totalBookings = Booking::count();
        $bookingCount = $mostPopularRoomType ? $mostPopularRoomType->bookings_count : 0;
        $popularityPercentage = $totalBookings > 0
            ? round(($bookingCount / $totalBookings) * 100, 2)
            : 0;

        // Additional Metrics
        $averageStay = Booking::where('payment_status', 'confirmed')
            ->selectRaw('AVG(DATEDIFF(check_out_date, check_in_date)) as average_duration')
            ->value('average_duration');

        $monthlyBookings = Booking::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return [
            'totalRooms' => Room::count(),
            'totalBookings' => $totalBookings,
            'totalGuests' => User::where('role', 'user')->count(),
            'profile' => auth()->user(),
            'chartLabels' => $labels,
            'chartData' => $bookingData,
            'guestChartLabels' => $labels,
            'guestChartData' => $guestData,
            'revenueChartData' => $revenueChartData,
            'detailBookings' => Booking::with('user')
                ->orderBy('created_at', 'desc')
                ->get(),
            'mostPopularRoomType' => $mostPopularRoomType?->name ?? 'N/A',
            'activeReservations' => Booking::where('payment_status', 'confirmed')->count(),
            'totalRevenue' => number_format(
                Booking::where('payment_status', 'confirmed')->sum('total_price'),
                2
            ),
            'bookingCount' => $bookingCount,
            'popularityPercentage' => $popularityPercentage,
            'averageStay' => round($averageStay ?? 0, 1),
            'monthlyBookings' => $monthlyBookings
        ];
    }
}
