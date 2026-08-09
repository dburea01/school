<?php

namespace App\Models;

use Database\Factories\ClassroomFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'academic_year_id',
    'name',
    'short_name',
    'comment',
    'created_by',
    'updated_by',
])]
class Classroom extends Model
{
    use HasCreatedUpdatedBy, HasUuids;

    /** @use HasFactory<ClassroomFactory> */
    use HasFactory;

    use SoftDeletes;
}
