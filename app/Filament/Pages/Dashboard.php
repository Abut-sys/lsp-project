<?php

namespace App\Filament\Admin\Pages;

use Filament\Pages\Page;
use App\Models\Room;
use App\Models\Booking;
use App\Models\User;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'filament.admin.pages.dashboard';

    public function getViewData(): array
    {
        // Data Booking per Bulan (untuk grafik)
        $bookings = Booking::selectRaw('MONTH(created_at) as month, COUNT(*) as count')->whereYear('created_at', now()->year)->groupBy('month')->pluck('count', 'month');

        $labels = [];
        $bookingData = [];

        for ($m = 1; $m <= 12; $m++) {
            $labels[] = date('F', mktime(0, 0, 0, $m, 1));
            $bookingData[] = $bookings->get($m, 0);
        }

        // Data Total Tamu per Bulan (untuk grafik)
        $guests = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')->where('role', 'user')->whereYear('created_at', now()->year)->groupBy('month')->pluck('count', 'month');

        $guestData = [];
        for ($m = 1; $m <= 12; $m++) {
            $guestData[] = $guests->get($m, 0);
        }

        $detailBookings = Booking::with('user')->orderBy('created_at', 'asc')->get();

        return [
            'totalRooms' => Room::count(),
            'totalBookings' => Booking::count(),
            'totalGuests' => User::where('role', 'user')->count(),
            'profile' => auth()->user(),
            'chartLabels' => $labels,
            'chartData' => $bookingData,
            'guestChartLabels' => $labels,
            'guestChartData' => $guestData,
            'detailBookings' => $detailBookings,
        ];
    }
}
