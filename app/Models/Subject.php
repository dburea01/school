<?php

namespace App\Models;

use Database\Factories\SubjectFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name',
    'short_name',
    'color',
    'is_active',
    'comment',
    'created_by',
    'updated_by',
])]
class Subject extends Model
{
    use HasCreatedUpdatedBy, HasUuids;

    /** @use HasFactory<SubjectFactory> */
    use HasFactory;

    public function setNameAttribute(string $value): void
    {
        $this->attributes['name'] = ucwords($value);
    }

    public function setShortNameAttribute(string $value): void
    {
        $this->attributes['short_name'] = strtoupper($value);
    }
}
