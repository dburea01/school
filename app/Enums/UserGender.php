<?php

namespace App\Enums;

enum UserGender: string
{
    case M = 'M';
    case F = 'F';
    case NB = 'NB';

    public function label(): string
    {
        return match ($this) {
            self::M => 'Masculin',
            self::F => 'Féminin',
            self::NB => 'Non binaire'
        };
    }
}
