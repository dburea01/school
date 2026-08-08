<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\Level;
use Illuminate\Database\Seeder;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $levels = Level::all();

        foreach ($levels as $level) {

            for ($i = 0; $i < rand(1, 5); $i++) {
                Classroom::factory()->create([
                    'level_id' => $level->id,
                ]);
            }

        }
    }
}
