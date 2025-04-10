<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\User;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        $now = Carbon::now();
        $startOfMonth = $now->startOfMonth();
        $endOfMonth = $now->endOfMonth();

        return [
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'room_id' => Room::inRandomOrder()->first()->id ?? Room::factory(),
            'status' => $this->faker->randomElement(['confirmed', 'pending', 'cancelled']),
            'check_in_date' => $this->faker->dateTimeBetween($startOfMonth, $endOfMonth),
            'check_out_date' => $this->faker->dateTimeBetween($startOfMonth, $endOfMonth),
            'created_at' => $this->faker->dateTimeBetween($startOfMonth, $endOfMonth),
        ];
    }
}
