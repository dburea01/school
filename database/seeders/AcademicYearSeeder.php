<?php

namespace Database\Seeders;

use App\Enums\AcademicYearStatus;
use App\Models\AcademicYear;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AcademicYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AcademicYear::factory()->create([
            'name' => '2024/2025',
            'start_date' => '01/09/2024',
            'end_date' => '31/08/2025',
            'status' => AcademicYearStatus::ARCHIVED
        ]);

        AcademicYear::factory()->create([
            'name' => '2025/2026',
            'start_date' => '01/09/2025',
            'end_date' => '31/08/2026',
            'status' => AcademicYearStatus::CURRENT
        ]);

        AcademicYear::factory()->create([
            'name' => '2026/2027',
            'start_date' => '01/09/2026',
            'end_date' => '31/08/2027',
            'status' => AcademicYearStatus::DRAFT
        ]);


    }
}
