<?php

namespace Database\Factories;

use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomTypeFactory extends Factory
{
    protected $model = RoomType::class;

    private static $roomTypes = [
        'Deluxe', 'Single Suite', 'Double Suite', 'Junior Suite',
        'Standard', 'Superior', 'Family Suite'
    ];

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElement(self::$roomTypes),
            'facilities' => $this->faker->randomElements([
                'wifi', 'ac', 'tv', 'pool', 'gym', 'restaurant'
            ], rand(2, 4)), // Pilih 2-4 fasilitas secara acak
        ];
    }
}
