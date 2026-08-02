<?php

namespace App\Enums;

enum UserStatus: string
{
    case ACTIVE = 'ACTIVE';
    case BLOCKED = 'BLOCKED';
    case ARCHIVED = 'ARCHIVED';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Actif',
            self::ARCHIVED => 'Archivé',
            self::BLOCKED => 'Bloqué',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::ACTIVE => 'La personne peut se connecter.',
            self::BLOCKED => 'La personne ne peut pas se connecter. La personne est sélectionnable pour affectation.',
            self::ARCHIVED => 'La personne ne peut pas se connecter. La personne n\'est pas séléctionnable pour affectation.',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::ACTIVE => 'success',
            self::BLOCKED => 'danger',
            self::ARCHIVED => 'warning',
        };
    }

    public function icon(): ?string
    {
        return match ($this) {
            self::ACTIVE => null, // Pas d'icône pour les actifs
            self::BLOCKED => 'bi-slash-circle-fill',
            self::ARCHIVED => 'bi-pause-fill',
        };
    }
}
