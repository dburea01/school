<?php

namespace App\Enums;

enum PeriodStatus: string
{
    case UPCOMING = 'UPCOMING';
    case OPEN = 'OPEN';
    case CLOSED = 'CLOSED';

    public function label(): string
    {
        return match ($this) {
            self::UPCOMING => 'A venir',
            self::OPEN => 'Ouverte',
            self::CLOSED => 'Cloturée',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::UPCOMING => 'info',
            self::OPEN => 'success',
            self::CLOSED => 'warning',
        };
    }
}
