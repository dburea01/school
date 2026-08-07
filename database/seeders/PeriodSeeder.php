<?php

namespace Database\Seeders;

use App\Enums\AcademicYearStatus;
use App\Enums\PeriodStatus;
use App\Models\AcademicYear;
use App\Models\Period;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $academicYears = AcademicYear::all();

        foreach ($academicYears as $academicYear) {
            $yearStart = Carbon::parse($academicYear->start_date);
            $yearEnd = Carbon::parse($academicYear->end_date);

            // Découpage réaliste des 3 trimestres basés sur la date de début
            $periodsConfig = [
                [
                    'name' => 'Trimestre 1',
                    'short_name' => 'T1',
                    'position' => 1,
                    'start_date' => $yearStart->copy()->format('d/m/Y'),
                    'end_date' => $yearStart->copy()->addMonths(3)->subDay()->format('d/m/Y'),
                ],
                [
                    'name' => 'Trimestre 2',
                    'short_name' => 'T2',
                    'position' => 2,
                    'start_date' => $yearStart->copy()->addMonths(3)->format('d/m/Y'),
                    'end_date' => $yearStart->copy()->addMonths(7)->subDay()->format('d/m/Y'),
                ],
                [
                    'name' => 'Trimestre 3',
                    'short_name' => 'T3',
                    'position' => 3,
                    'start_date' => $yearStart->copy()->addMonths(7)->format('d/m/Y'),
                    'end_date' => $yearEnd->format('d/m/Y'),
                ],
            ];

            foreach ($periodsConfig as $periodData) {
                // Attribution cohérente du statut de la période selon le statut de l'année
                $status = match ($academicYear->status) {
                    AcademicYearStatus::ARCHIVED => PeriodStatus::CLOSED,
                    AcademicYearStatus::DRAFT => PeriodStatus::UPCOMING,
                    AcademicYearStatus::CURRENT => match ($periodData['position']) {
                        1 => PeriodStatus::CLOSED,   // T1 déjà fini
                        2 => PeriodStatus::OPEN,     // T2 en cours
                        3 => PeriodStatus::UPCOMING, // T3 à venir
                    },
                };

                Period::factory()->create(array_merge($periodData, [
                    'academic_year_id' => $academicYear->id,
                    'status' => $status,
                ]));
            }
        }
    }
}
