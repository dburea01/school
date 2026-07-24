<?php

namespace App\Enums;

enum UserGender: string
{
    case MALE = 'M';
    case FEMALE = 'F';
    case NONBINARY = 'NB';

    public function label(): string
    {
        return match ($this) {
            self::MALE => 'Masculin',
            self::FEMALE => 'Féminin',
            self::NONBINARY => 'Non binaire'
        };
    }
}
