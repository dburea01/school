<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name',
    'address',
    'city',
    'postal_code',
    'country_id',
    'created_by',
    'updated_by',
])]
class School extends Model
{
    use HasUuids, HasCreatedUpdatedBy;
}
