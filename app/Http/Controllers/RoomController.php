<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Room;
use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RoomController extends Controller
{
    public function show($roomNumber)
    {
        $room = Room::where('room_number', $roomNumber)->with('roomType')->firstOrFail();

        $images = collect($room->images)->map(function ($image) {
            return Storage::url($image);
        });

        $isWishlisted = auth()->check() ? auth()->user()->wishlists()->where('room_id', $room->id)->exists() : false;

        $existingBookings = Booking::where('room_id', $room->id)->where('payment_status', 'confirmed')->where('check_out_date', '>', now())->get();

        $userBookings = collect();
        if (auth()->check()) {
            $userBookings = auth()->user()->bookings()->where('room_id', $room->id)->where('payment_status', 'confirmed')->where('check_out_date', '>', now())->get();
        }

        $disabledDates = [];

        foreach ($existingBookings as $booking) {
            $checkIn = Carbon::parse($booking->check_in_date);
            $checkOut = Carbon::parse($booking->check_out_date);

            while ($checkIn->lte($checkOut)) {
                $disabledDates[] = $checkIn->toDateString();
                $checkIn->addDay();
            }
        }

        foreach ($userBookings as $booking) {
            $checkIn = Carbon::parse($booking->check_in_date);
            $checkOut = Carbon::parse($booking->check_out_date);

            while ($checkIn->lte($checkOut)) {
                $disabledDates[] = $checkIn->toDateString();
                $checkIn->addDay();
            }
        }

        $disabledDates = array_unique($disabledDates);
        sort($disabledDates);

        return view('room-show', [
            'room' => $room,
            'isWishlisted' => $isWishlisted,
            'images' => $images,
            'userBookings' => $userBookings,
            'existingBookings' => $existingBookings,
            'disabledDates' => $disabledDates,
        ]);
    }
}
