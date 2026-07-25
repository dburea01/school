<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'ADMIN';
    case DIRECTOR = 'DIRECTOR';
    case TEACHER = 'TEACHER';
    case PARENT = 'PARENT';
    case STUDENT = 'ECOLIER';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrateur',
            self::DIRECTOR => 'Directeur',
            self::TEACHER => 'Enseignant',
            self::PARENT => 'Parent',
            self::STUDENT => 'Ecolier',
        };
    }
}
