<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            [
                'short_name' => 'FRA',
                'name'       => 'Français',
                'color'      => 'lightblue',
                'is_active'  => true,
                'comment'    => 'Tronc commun - Langue et littérature',
            ],
            [
                'short_name' => 'MATHS',
                'name'       => 'Mathématiques',
                'color'      => 'peachpuff',
                'is_active'  => true,
                'comment'    => 'Tronc commun - Raisonnement et calcul',
            ],
            [
                'short_name' => 'HIST-GEO',
                'name'       => 'Histoire-Géographie',
                'color'      => 'khaki',
                'is_active'  => true,
                'comment'    => 'Tronc commun - Histoire, géographie et EMC',
            ],
            [
                'short_name' => 'SVT',
                'name'       => 'Sciences de la Vie et de la Terre',
                'color'      => 'palegreen',
                'is_active'  => true,
                'comment'    => 'Sciences naturelles et biologie',
            ],
            [
                'short_name' => 'PHYS-CHIM',
                'name'       => 'Physique-Chimie',
                'color'      => 'paleturquoise',
                'is_active'  => true,
                'comment'    => 'Sciences physiques et expérience',
            ],
            [
                'short_name' => 'ANG',
                'name'       => 'Anglais',
                'color'      => 'mistyrose',
                'is_active'  => true,
                'comment'    => 'Langue vivante 1 / 2',
            ],
            [
                'short_name' => 'ESP',
                'name'       => 'Espagnol',
                'color'      => 'papayawhip',
                'is_active'  => true,
                'comment'    => 'Langue vivante 2',
            ],
            [
                'short_name' => 'ALL',
                'name'       => 'Allemand',
                'color'      => 'palegoldenrod',
                'is_active'  => true,
                'comment'    => 'Langue vivante 1 / 2',
            ],
            [
                'short_name' => 'LATIN',
                'name'       => 'Latin',
                'color'      => 'blanchedalmond',
                'is_active'  => true,
                'comment'    => 'Langue et culture de l\'Antiquité (Option)',
            ],
            [
                'short_name' => 'GREC',
                'name'       => 'Grec ancien',
                'color'      => 'lavender',
                'is_active'  => true,
                'comment'    => 'Langue et culture de l\'Antiquité (Option)',
            ],
            [
                'short_name' => 'EPS',
                'name'       => 'Éducation Physique et Sportive',
                'color'      => 'gainsboro',
                'is_active'  => true,
                'comment'    => 'Activités physiques et sportives',
            ],
            [
                'short_name' => 'ARTS',
                'name'       => 'Arts Plastiques',
                'color'      => 'thistle',
                'is_active'  => true,
                'comment'    => 'Pratique et culture artistique',
            ],
            [
                'short_name' => 'MUSIQUE',
                'name'       => 'Éducation Musicale',
                'color'      => 'pink',
                'is_active'  => true,
                'comment'    => 'Chant et culture musicale',
            ],
            [
                'short_name' => 'TECH',
                'name'       => 'Technologie',
                'color'      => 'powderblue',
                'is_active'  => true,
                'comment'    => 'Informatique, conception et objets techniques',
            ],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }
    }
}
