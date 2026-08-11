<?php

namespace App\Models;

use Database\Factories\AssignmentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'user_id',
    'classroom_id',
    'subject_id',
    'start_at',
    'end_at',
    'comment',
    'created_by',
    'updated_by',
])]
class Assignment extends Model
{
    use HasCreatedUpdatedBy, HasUuids;

    /** @use HasFactory<AssignmentFactory> */
    use HasFactory;
}
