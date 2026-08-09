<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Classroom;
use Illuminate\Database\Seeder;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $academicYears = AcademicYear::all();
        $levels = ['6ème', '5ème', '4ème', '3ème'];

        foreach ($academicYears as $academicYear) {
            foreach ($levels as $level) {
                $count = rand(2, 4); // 2, 3 ou 4 classes par niveau

                for ($i = 0; $i < $count; $i++) {
                    $letter = chr(65 + $i); // Génère 'A', 'B', 'C', 'D'

                    Classroom::factory()->create([
                        'academic_year_id' => $academicYear->id,
                        'name'             => "{$level} {$letter}",                     // Ex: "6ème A"
                        'short_name'       => str_replace('ème', '', $level) . $letter, // Ex: "6A"
                    ]);
                }
            }
        }
    }
}
