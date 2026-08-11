<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Assignment;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Seeder;

class AssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classrooms = Classroom::all();
        $subjects = Subject::all();
        $users = User::all();
        $students = $users->filter(function ($user) {
            return $user->role == UserRole::STUDENT;
        });
        $teachers = $users->filter(function ($user) {
            return $user->role == UserRole::TEACHER;
        });

        foreach ($classrooms as $classroom) {

            $studentsRandom = $students->random(rand(1, $students->count()));
            $teachersRandom = $teachers->random(rand(1, $teachers->count()));

            foreach ($studentsRandom as $student) {
                Assignment::factory()->create([
                    'classroom_id' => $classroom->id,
                    'user_id' => $student->id,
                ]);
            }

            foreach ($teachersRandom as $teacher) {
                Assignment::factory()->create([
                    'classroom_id' => $classroom->id,
                    'user_id' => $teacher->id,
                    'subject_id' => $subjects->random()->id,
                ]);
            }
        }
    }
}
