<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'ADMIN';
    case DIRECTOR = 'DIRECTOR';
    case TEACHER = 'TEACHER';
    case PARENT = 'PARENT';
    case STUDENT = 'STUDENT';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrateur',
            self::DIRECTOR => 'Directeur',
            self::TEACHER => 'Enseignant',
            self::PARENT => 'Parent',
            self::STUDENT => 'Elève',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::ADMIN => 'bg-danger-subtle text-danger-emphasis',
            self::DIRECTOR => 'bg-warning-subtle text-warning-emphasis',
            self::TEACHER => 'bg-primary-subtle text-primary-emphasis',
            self::PARENT => 'bg-info-subtle text-info-emphasis',
            self::STUDENT => 'bg-success-subtle text-success-emphasis',
        };
    }
}
