<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory ,SoftDeletes;

    protected $fillable = [
        'user_id',
        'room_id',
        'check_in_date',
        'check_out_date',
        'status',
    ];

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
}
