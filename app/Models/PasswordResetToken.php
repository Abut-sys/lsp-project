<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    use HasFactory;

    protected $table = 'password_reset_tokens'; // Nama tabel

    protected $primaryKey = 'email'; // Set primary key

    public $incrementing = false; // Karena primary key bukan integer auto-increment

    protected $fillable = ['email', 'token', 'created_at'];

    public $timestamps = false; // Tidak menggunakan timestamps default Laravel
}

