<?php

namespace App\Enums;

enum UserStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Actif',
            self::INACTIVE => 'Inactif',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::ACTIVE => 'La personne peut se connecter.',
            self::INACTIVE => 'La personne ne peut pas se connecter.',
        };
    }
}
