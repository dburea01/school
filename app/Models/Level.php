<?php

namespace App\Models;

use Database\Factories\LevelFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'academic_year_id',
    'name',
    'short_name',
    'position',
    'comment',
    'created_by',
    'updated_by',
])]
class Level extends Model
{
    use HasCreatedUpdatedBy, HasUuids;

    /** @use HasFactory<LevelFactory> */
    use HasFactory;

    use SoftDeletes;
}
