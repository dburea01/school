<?php

namespace App\Models;

use Database\Factories\AssignmentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return BelongsTo<Subject, $this> */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
}
