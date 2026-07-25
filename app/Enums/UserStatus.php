<?php

namespace App\Enums;

enum UserStatus: string
{
    case ACTIVE = 'ACTIVE';
    case INACTIVE = 'INACTIVE';

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
