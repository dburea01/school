<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserGender;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property UserStatus $status
 * @property UserRole $role
 */
#[Fillable([
    'last_name',
    'first_name',
    'role',
    'status',
    'gender',
    'email',
    'email_verified_at',
    'password',
    'birth_date',
    'phone_number',
    'address',
    'city',
    'postal_code',
    'country_id',
    'comment',
    'created_by',
    'updated_by',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasCreatedUpdatedBy, HasFactory, HasUuids, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
            'gender' => UserGender::class,
            'status' => UserStatus::class,
            'birth_date' => 'datetime:d/m/Y',
        ];
    }

    public function getInitialsAttribute(): string
    {
        $first = mb_substr($this->first_name ?? '', 0, 1);
        $last = mb_substr($this->last_name ?? '', 0, 1);

        return strtoupper($first.$last);
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function setFirstNameAttribute(string $value): void
    {
        $this->attributes['first_name'] = ucwords($value);
    }

    public function setLastNameAttribute(string $value): void
    {
        $this->attributes['last_name'] = strtoupper($value);
    }

    public function isAdmin(): bool
    {
        return $this->role == UserRole::ADMIN;
    }

    public function isDirector(): bool
    {
        return $this->role == UserRole::DIRECTOR;
    }

    public function isTeacher(): bool
    {
        return $this->role == UserRole::TEACHER;
    }

    public function isParent(): bool
    {
        return $this->role == UserRole::PARENT;
    }

    public function isStudent(): bool
    {
        return $this->role == UserRole::STUDENT;
    }
}
