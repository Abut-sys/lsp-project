<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Room;
use App\Models\User;
use App\Models\Booking;
use App\Models\Facility;
use App\Models\RoomType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@hotel.com',
            'password' => bcrypt('password'), // Pastikan untuk menggunakan Hash::make() atau bcrypt()
            'role' => 'admin',
        ]);

        // Buat 20 user dengan role 'user'
        User::factory(20)->create([
            'role' => 'user',
        ]);

        RoomType::factory(7)->create();

        Room::factory(1)->create();

        // Booking::factory(1)->create();

        // User biasa
        User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'), // Ganti dengan password yang lebih aman
            'role' => 'user',
        ]);
        User::create([
            'name' => 'Hotel User',
            'email' => 'user@hotel.com',
            'password' => Hash::make('password'), // Ganti dengan password yang lebih aman
            'role' => 'user',
        ]);
    }
}
