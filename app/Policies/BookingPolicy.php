<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    public function delete(User $user, Booking $booking)
    {
        return $user->role === 'admin'; // Pastikan hanya admin yang bisa menghapus
    }
}
