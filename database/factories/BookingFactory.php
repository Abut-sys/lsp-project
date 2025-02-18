<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\User;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    public function definition(): array
    {
        return [
            'user_id'    => User::inRandomOrder()->first()->id ?? User::factory(),
            'room_id'    => Room::inRandomOrder()->first()->id ?? Room::factory(),
            'status'     => $this->faker->randomElement(['confirmed', 'pending', 'cancelled']),
            'check_in_date'  => $this->faker->dateTimeBetween('now', '+1 month'),
            'check_out_date' => $this->faker->dateTimeBetween('+1 month', '+2 months'),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
