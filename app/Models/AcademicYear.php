<?php

namespace App\Models;

use App\Enums\AcademicYearStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    /** @use HasFactory<\Database\Factories\AcademicYearFactory> */
    use HasFactory;

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
}
