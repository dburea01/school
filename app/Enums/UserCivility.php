<?php

namespace App\Enums;

enum UserCivility: string
{
    case MISTER = 'M';
    case MADAM = 'MME';

    public function label(): string
    {
        return match ($this) {
            self::MISTER => 'Monsieur',
            self::MADAM => 'Madame',
        };
    }
}
