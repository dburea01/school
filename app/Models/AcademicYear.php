<?php

namespace App\Models;

use App\Enums\AcademicYearStatus;
use Carbon\Carbon;
use Database\Factories\AcademicYearFactory;
use DomainException;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $id
 * @property string $name
 * @property AcademicYearStatus $status <-- Informe Larastan du type Enum
 * @property Carbon $start_date <-- Indique à Larastan que c'est une instance Carbon
 * @property Carbon $end_date <-- Indique à Larastan que c'est une instance Carbon
 */
#[Fillable([
    'name',
    'start_date',
    'end_date',
    'status',
    'comment',
    'created_by',
    'updated_by',
])]
class AcademicYear extends Model
{
    use HasCreatedUpdatedBy, HasUuids;

    /** @use HasFactory<AcademicYearFactory> */
    use HasFactory;

    use SoftDeletes;

    protected static function booted(): void
    {
        // Ce hook est exécuté AUTOMATIQUEMENT avant CHAQUE suppression
        static::deleting(function (AcademicYear $academicYear) {
            if ($academicYear->status !== AcademicYearStatus::DRAFT) {
                // On empêche la suppression en levant une exception
                throw new DomainException("Seule une année scolaire au statut 'Brouillon' peut être supprimée.");
            }
        });
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => AcademicYearStatus::class,
            'start_date' => 'datetime',
            'end_date' => 'datetime',
        ];
    }

    public function setStartDateAttribute(?string $value): void
    {
        $this->attributes['start_date'] = empty($value)
            ? null
            // @phpstan-ignore-next-line
            : Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function setEndDateAttribute(?string $value): void
    {
        $this->attributes['end_date'] = empty($value)
            ? null
            // @phpstan-ignore-next-line
            : Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    /** @return HasMany<Period, $this> */
    public function periods(): HasMany
    {
        return $this->hasMany(Period::class);
    }

    /** @return HasMany<Classroom, $this> */
    public function classrooms(): HasMany
    {
        return $this->hasMany(Classroom::class);
    }
}
