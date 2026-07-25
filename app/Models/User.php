<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserCivility;
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

#[Fillable([
    'last_name', 
    'first_name',
    'role',
    'status',
    'civility',
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
    'updated_by'
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasUuids;

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
            'civility' => UserCivility::class,
            'gender' => UserGender::class,
            'status' => UserStatus::class
        ];
    }

    public function getFullNameAttribute(): string
    {
        return $this->last_name.' '.$this->first_name;
    }

    public function setFirstNameAttribute(string $value): void
    {
        $this->attributes['first_name'] = ucwords($value);
    }

    public function setLastNameAttribute(string $value): void
    {
        $this->attributes['last_name'] = strtoupper($value);
    }
}
