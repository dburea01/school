<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Level;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $academicYears = AcademicYear::all();

        foreach ($academicYears as $academicYear) {

            Level::factory()->create([
                'academic_year_id' => $academicYear->id,
                'name' => 'Les 6èmes',
                'short_name' => '6',
                'position' => '1',
            ]);

            Level::factory()->create([
                'academic_year_id' => $academicYear->id,
                'name' => 'Les 5èmes',
                'short_name' => '5',
                'position' => '2',
            ]);

            Level::factory()->create([
                'academic_year_id' => $academicYear->id,
                'name' => 'Les 4èmes',
                'short_name' => '4',
                'position' => '3',
            ]);

            Level::factory()->create([
                'academic_year_id' => $academicYear->id,
                'name' => 'Les 3èmes',
                'short_name' => '3',
                'position' => '4',
            ]);

        }
    }
}
