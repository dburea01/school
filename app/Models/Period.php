<?php

namespace App\Models;

use App\Enums\AcademicYearStatus;
use App\Enums\PeriodStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $id
 * @property string $name
 * @property PeriodStatus $status  <-- Informe Larastan du type Enum
 */

#[Fillable([
    'academic_year_id',
    'name',
    'short_name',
    'position',
    'start_date',
    'end_date',
    'status',
    'comment',
    'created_by',
    'updated_by',
])]
class Period extends Model
{
    /** @use HasFactory<\Database\Factories\PeriodFactory> */
    use HasFactory;

    use HasUuids, HasCreatedUpdatedBy;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => PeriodStatus::class,
            'start_date' => 'datetime',
            'end_date' => 'datetime',
        ];
    }
}
