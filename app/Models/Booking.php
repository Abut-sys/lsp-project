<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'room_id', 'check_in_date', 'check_out_date', 'status', 'total_price'];

    protected $dates = ['deleted_at'];

    /**
     * Relasi ke model User (satu reservasi hanya untuk satu user)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke model Room (satu reservasi hanya untuk satu kamar)
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Scope untuk mendapatkan reservasi yang masih aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'confirmed');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if ($booking->isDoubleBooked()) {
                throw new \Exception('Kamar ini sudah dipesan pada tanggal yang dipilih.');
            }
            $booking->calculateTotalPrice();
        });

        static::updating(function ($booking) {
            if ($booking->isDoubleBooked()) {
                throw new \Exception('Kamar ini sudah dipesan pada tanggal yang dipilih.');
            }
            $booking->calculateTotalPrice();
        });

        static::saved(function ($booking) {
            $room = $booking->room;
            if ($room) {
                $room->is_booked = $room->bookings()->where('status', 'confirmed')->exists();
                $room->saveQuietly();
            }
        });

        static::deleted(function ($booking) {
            $room = $booking->room;
            if ($room) {
                $room->is_booked = $room->bookings()->where('status', 'confirmed')->exists();
                $room->saveQuietly();
            }
        });
    }

    /**
     * Periksa apakah kamar sudah dipesan dalam rentang waktu yang sama.
     */
    public function isDoubleBooked(): bool
    {
        return self::where('room_id', $this->room_id)
            ->where('status', 'confirmed')
            ->where(function ($query) {
                $query->whereBetween('check_in_date', [$this->check_in_date, $this->check_out_date])
                    ->orWhereBetween('check_out_date', [$this->check_in_date, $this->check_out_date])
                    ->orWhere(function ($q) {
                        $q->where('check_in_date', '<=', $this->check_in_date)
                            ->where('check_out_date', '>=', $this->check_out_date);
                    });
            })
            ->exists();
    }

    /**
     * Hitung total harga berdasarkan jumlah malam dan harga kamar.
     */
    public function calculateTotalPrice()
    {
        $room = Room::find($this->room_id);
        if ($room && $this->check_in_date && $this->check_out_date) {
            $checkIn = $this->check_in_date instanceof \DateTime ? $this->check_in_date->getTimestamp() : strtotime($this->check_in_date);
            $checkOut = $this->check_out_date instanceof \DateTime ? $this->check_out_date->getTimestamp() : strtotime($this->check_out_date);

            $nights = max(1, ($checkOut - $checkIn) / 86400);
            $this->total_price = $room->price * $nights;
        }
    }
}
