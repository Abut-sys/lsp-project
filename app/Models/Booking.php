<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'room_id', 'check_in_date', 'check_out_date', 'payment_status', 'total_price', 'midtrans_token'];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'total_price' => 'decimal:0',
    ];

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
     * Scope untuk mendapatkan reservasi yang masih aktif (dibayar/confirmed)
     */
    public function scopeActive($query)
    {
        return $query->where('payment_status', 'confirmed');
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
                $room->is_booked = $room->bookings()->where('payment_status', 'confirmed')->where('check_out_date', '>', now())->exists();
                $room->saveQuietly();
            }
        });

        static::deleted(function ($booking) {
            $room = $booking->room;
            if ($room) {
                $room->is_booked = $room->bookings()->where('payment_status', 'confirmed')->exists();
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
            ->where('payment_status', 'confirmed')
            ->where(function ($query) {
                $query
                    ->where(function ($q) {
                        $q->whereBetween('check_in_date', [$this->check_in_date, $this->check_out_date])->orWhereBetween('check_out_date', [$this->check_in_date, $this->check_out_date]);
                    })
                    ->orWhere(function ($q) {
                        $q->where('check_in_date', '<=', $this->check_in_date)->where('check_out_date', '>=', $this->check_out_date);
                    });
            })
            ->exists();
    }

    /**
     * Hitung total harga berdasarkan jumlah malam dan harga kamar.
     */
    public function calculateTotalPrice()
    {
        $room = $this->room;
        if ($room && $this->check_in_date && $this->check_out_date) {
            $checkIn = Carbon::parse($this->check_in_date);
            $checkOut = Carbon::parse($this->check_out_date);
            $nights = max(1, $checkIn->diffInDays($checkOut));
            $this->total_price = $room->price * $nights;
        }
    }

    public function getPaymentUrl()
    {
        $serverKey = config('services.midtrans.server_key');
        $url = 'https://app.sandbox.midtrans.com/snap/v1/transactions';

        $response = Http::withBasicAuth($serverKey, '')->post($url, [
            'transaction_details' => [
                'order_id' => $this->id,
                'gross_amount' => $this->total_price,
            ],
            'customer_details' => [
                'first_name' => $this->user->name,
                'email' => $this->user->email,
            ],
            'callbacks' => [
                'finish' => url('/api/midtrans/callback'),
            ],
        ]);

        $result = $response->json();
        return $result['redirect_url'] ?? null;
    }
}
