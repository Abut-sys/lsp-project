<?php

namespace Database\Factories;

use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomTypeFactory extends Factory
{
    protected $model = RoomType::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word,
            'facility_id' => \App\Models\Facility::inRandomOrder()->value('id')->id ?? \App\Models\Facility::factory(),
        ];
    }
}
