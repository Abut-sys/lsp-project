<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'images',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function roomTypes()
    {
        return $this->hasMany(RoomType::class);
    }
}
