<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['room_type_id', 'room_number', 'capacity', 'images', 'price', 'description', 'is_available', 'is_booked'];

    protected $casts = [
        'images' => 'array',
    ];

    /**
     * Relasi ke model RoomType
     */
    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    /**
     * Relasi ke model Booking (satu kamar bisa memiliki banyak reservasi)
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getIsBookedAttribute()
    {
        return $this->bookings()
            ->where('payment_status', 'confirmed')
            ->where(function ($query) {
                $query->where('check_out_date', '>', now())->orWhereNull('check_out_date');
            })
            ->exists();
    }

    public function isAvailable($checkIn, $checkOut)
    {
        return !$this->bookings()
            ->where('payment_status', 'confirmed')
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query
                    ->whereBetween('check_in_date', [$checkIn, $checkOut])
                    ->orWhereBetween('check_out_date', [$checkIn, $checkOut])
                    ->orWhere(function ($q) use ($checkIn, $checkOut) {
                        $q->where('check_in_date', '<=', $checkIn)->where('check_out_date', '>=', $checkOut);
                    });
            })
            ->exists();
    }

    public function wishlists()
    {
        return $this->belongsToMany(User::class, 'wishlists', 'room_id', 'user_id');
    }

    public function isWishlistedByUser($user)
    {
        return $this->wishlists()->where('user_id', $user->id)->exists();
    }
}
