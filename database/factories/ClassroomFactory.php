<?php

namespace Database\Factories;

use App\Models\Classroom;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Classroom>
 */
class ClassroomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'name '.fake('fr_FR')->word(),
            'short_name' => 'sn'.rand(1, 100),
            'position' => rand(1, 10),
            'comment' => fake()->sentence(),
        ];
    }
}
