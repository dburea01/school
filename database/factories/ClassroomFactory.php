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
        $suffixe = fake()->word();

        return [
            'name' => 'Classe '.$suffixe,
            'short_name' => $suffixe,
            'position' => rand(1, 10),
            'comment' => fake()->sentence(),
        ];
    }
}
