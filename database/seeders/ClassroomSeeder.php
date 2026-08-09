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

        foreach ($academicYears as $academicYear) {

            Classroom::factory()->count(rand(5, 10))->create([
                'academic_year_id' => $academicYear->id,
            ]);
        }
    }
}
