<?php

namespace Database\Seeders;

use App\Models\RelationShip;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // 1 admin
        User::factory()->create([
            'role' => 'ADMIN',
            'status' => 'ACTIVE',
            'gender' => null,
        ]);

        // 1 director
        User::factory()->create([
            'role' => 'DIRECTOR',
            'status' => 'ACTIVE',
            'gender' => null,
        ]);

        // some teachers
        User::factory()->count(rand(5, 10))->create([
            'role' => 'TEACHER',
            'status' => 'ACTIVE',
            'gender' => null,
        ]);

        // some families
        for ($i = 0; $i < 10; $i++) {
            $lastName = fake('fr_FR')->lastName();

            // 1 father and 1 mother
            $father = User::factory()->create([
                'role' => 'PARENT',
                'last_name' => $lastName,
                'gender' => null,
            ]);

            $mother = User::factory()->create([
                'role' => 'PARENT',
                'last_name' => $lastName,
                'gender' => null,
            ]);

            // some students
            $students = User::factory()->count(rand(1, 3))->create([
                'last_name' => $lastName,
                'role' => 'STUDENT',
            ]);

            // the links between parents and students
            $this->create_relation_ships($father, $students);
            $this->create_relation_ships($mother, $students);
        }
    }

    /** @param Collection<int,User> $students */
    public function create_relation_ships(User $parent, $students): void
    {

        foreach ($students as $student) {
            RelationShip::create([
                'parent_id' => $parent->id,
                'student_id' => $student->id,
            ]);
        }
    }
}
