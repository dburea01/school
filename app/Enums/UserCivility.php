<?php

namespace App\Enums;

enum UserCivility: string
{
    case M = 'M';
    case MME = 'MME';

    public function label(): string
    {
        return match ($this) {
            self::M => 'Monsieur',
            self::MME => 'Madame',
        };
    }
}
