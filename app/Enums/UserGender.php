<?php

namespace App\Enums;

enum UserGender: string
{
    case M = 'M';
    case F = 'F';
    case A = 'A';

    public function label(): string
    {
        return match ($this) {
            self::M => 'Masculin',
            self::F => 'Féminin',
            self::A => 'Autre'
        };
    }
}
