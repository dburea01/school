<?php

namespace App\Enums;

enum AcademicYearStatus: string
{
    case DRAFT = 'DRAFT';
    case CURRENT = 'CURRENT';
    case ARCHIVED = 'ARCHIVED';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Brouillon',
            self::ARCHIVED => 'Archivée',
            self::CURRENT => 'Courante',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::DRAFT => "Permet d'anticiper l'année suivante (création des classes, emplois du temps, affectations). Aucune saisie quotidienne (notes, absences) n'est possible.",
            self::CURRENT => "L'année scolaire de référence pour tout l'établissement. Toutes les données quotidiennes (cahier de texte, notes, absences) y sont rattachées.",
            self::ARCHIVED => "L'année est clôturée. Toutes les données sont verrouillées en lecture seule et restent accessibles uniquement pour la consultation de l'historique et l'impression des bulletins.",
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DRAFT => 'info',
            self::CURRENT => 'success',
            self::ARCHIVED => 'warning',
        };
    }
}
