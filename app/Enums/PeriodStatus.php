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

    public function description(): string
    {
        return match ($this) {
            self::UPCOMING => 'La période est à venir. Non encore ouverte.',
            self::OPEN => 'La période est ouverte à la saisie de notes.',
            self::CLOSED => "La période est fermée. Plus possible d'y saisir des notes.",
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
