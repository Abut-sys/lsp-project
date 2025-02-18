<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Booking;
use Filament\Notifications\Notification;

class BookingObserver
{
    /**
     * Handle the Booking "created" event.
     */
    public function created(Booking $booking): void
    {
        Notification::make()
            ->title('Pemesanan Baru!')
            ->body("Pelanggan telah memesan kamar #{$booking->room_id}.")
            ->success()
            ->sendToDatabase(User::all());
    }

    /**
     * Handle the Booking "updated" event.
     */
    public function updated(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "deleted" event.
     */
    public function deleted(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "restored" event.
     */
    public function restored(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "force deleted" event.
     */
    public function forceDeleted(Booking $booking): void
    {
        //
    }
}
