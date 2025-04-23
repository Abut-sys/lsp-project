<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomType;
use Carbon\Carbon;

class RoomListController extends Controller
{
    public function showPopularHotels(Request $request)
    {
        $query = Room::with(['roomType', 'bookings']);
        $roomTypes = RoomType::pluck('name', 'id');
        $sortBy = $request->query('sort_by');
        $checkIn = null;
        $checkOut = null;

        // Filter Tanggal
        if ($request->filled(['check_in', 'check_out'])) {
            try {
                $checkIn = Carbon::parse($request->check_in)->startOfDay();
                $checkOut = Carbon::parse($request->check_out)->startOfDay();

                if ($checkOut->gt($checkIn)) {
                    $query->whereDoesntHave('bookings', function ($q) use ($checkIn, $checkOut) {
                        $q->where('payment_status', 'confirmed')
                          ->where(function ($query) use ($checkIn, $checkOut) {
                              $query->whereBetween('check_in_date', [$checkIn, $checkOut])
                                    ->orWhereBetween('check_out_date', [$checkIn, $checkOut])
                                    ->orWhere(function ($q) use ($checkIn, $checkOut) {
                                        $q->where('check_in_date', '<', $checkIn)
                                          ->where('check_out_date', '>', $checkOut);
                                    });
                          });
                    });
                }
            } catch (\Exception $e) {
                // Handle invalid date format
            }
        }

        // Filter Pencarian
        if ($request->filled('query')) {
            $query->whereHas('roomType', function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->query('query').'%');
            });
        }

        // Filter Lainnya
        $request->whenFilled('rooms', function ($value) use ($query) {
            $query->where('room_number', $value);
        });

        $request->whenFilled('guests', function ($value) use ($query) {
            $query->where('capacity', '>=', $value);
        });

        $request->whenFilled('is_available', function ($value) use ($query) {
            $query->where('is_available', filter_var($value, FILTER_VALIDATE_BOOLEAN));
        });

        // Sorting
        if ($sortBy === 'price') {
            $query->orderBy('price');
        } elseif ($sortBy === 'kamar_terbaik') {
            $query->withCount(['bookings as popularity' => function ($q) {
                $q->where('payment_status', 'confirmed');
            }])->orderBy('popularity', 'desc');
        }

        $hotels = $query->paginate(12);

        return view('welcome', compact(
            'hotels',
            'roomTypes',
            'sortBy',
            'checkIn',
            'checkOut'
        ));
    }
}
