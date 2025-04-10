<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomType;

class RoomListController extends Controller
{
    public function showPopularHotels(Request $request)
    {
        $query = Room::with([
            'roomType',
            'bookings' => function ($q) {
                $q->where('payment_status', 'confirmed')->where('check_out_date', '>', now());
            },
        ]);

        $roomTypes = RoomType::pluck('name', 'id');

        // Filter pencarian
        if ($request->filled('query')) {
            $query->whereHas('roomType', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->query('query') . '%');
            });
        }

        // Filter nomor kamar
        if ($request->filled('rooms')) {
            $query->where('room_number', $request->rooms);
        }

        // Filter kapasitas
        if ($request->filled('guests')) {
            $query->where('capacity', '>=', $request->guests);
        }

        // Filter ketersediaan (diperbaiki)
        if ($request->filled('is_available')) {
            $isAvailable = filter_var($request->is_available, FILTER_VALIDATE_BOOLEAN);
            $query->where('is_available', $isAvailable);
        }

        $hotels = $query->paginate(12);

        return view('welcome', compact('hotels', 'roomTypes'));
    }
}
