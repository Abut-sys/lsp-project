<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class RoomListController extends Controller
{
    public function showPopularHotels(Request $request)
    {
        $request->validate([
            'check_in' => 'nullable|date',
            'check_out' => 'nullable|date|after:check_in',
            'query' => 'nullable|string|max:255',
            'rooms' => 'nullable|exists:rooms,id',
            'guests' => [
                'nullable',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->filled('rooms')) {
                        $room = Room::find($request->rooms);
                        if ($room && $value > $room->capacity) {
                            $fail("The number of guests cannot exceed room capacity ({$room->capacity} people).");
                        }
                    }
                }
            ],
            'is_available' => 'nullable|boolean',
            'sort_by' => 'nullable|in:price,kamar_terbaik'
        ]);

        $query = Room::with(['roomType', 'bookings']);
        $roomTypes = RoomType::pluck('name', 'id');
        $sortBy = $request->query('sort_by');
        $checkIn = null;
        $checkOut = null;

        // Date Filter
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
            }
        }

        // Search Filter
        if ($request->filled('query')) {
            $query->whereHas('roomType', function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->query('query').'%');
            });
        }

        // Room Number Filter
        $request->whenFilled('rooms', function ($value) use ($query) {
            $query->where('id', $value);
        });

        // Guest Capacity Filter
        $request->whenFilled('guests', function ($value) use ($query) {
            $query->where('capacity', '>=', $value);
        });

        // Availability Filter
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
