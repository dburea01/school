<?php

namespace App\Models;

use App\Enums\UserRole;
use Database\Factories\ClassroomFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'academic_year_id',
    'name',
    'short_name',
    'user_id',
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

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return HasMany<Assignment, $this> */
    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    // Élèves affectés (filtrés par le rôle STUDENT)
    /** @return BelongsToMany<User, $this> */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'assignments')
            ->where('users.role', UserRole::STUDENT)
            ->distinct();
    }

    // Enseignants affectés (filtrés par le rôle TEACHER)
    /** @return BelongsToMany<User, $this> */
    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'assignments')
            ->where('users.role', UserRole::TEACHER)
            ->distinct();
    }
}
