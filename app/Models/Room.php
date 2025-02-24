<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_type_id',
        'room_number',
        'capacity',
        'price',
        'description',
        'is_available',
        'is_booked',
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
        return $this->bookings()->where('status', 'confirmed')->exists();
    }
}
