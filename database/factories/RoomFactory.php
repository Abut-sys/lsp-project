<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Room;
use App\Models\RoomType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition(): array
    {
        return [
            'room_type_id' => RoomType::inRandomOrder()->first()->id ?? RoomType::factory(),
            'room_number' => $this->faker->unique()->numberBetween(100, 999),
            'capacity' => $this->faker->randomElement([1, 2, 3, 4]),
            'price' => $this->faker->randomFloat(850000, 1000000, 1340000),
            'description' => $this->faker->paragraph,
            'is_available' => $this->faker->boolean(70),
            'is_booked' => $this->faker->boolean(30),
        ];
    }
}
