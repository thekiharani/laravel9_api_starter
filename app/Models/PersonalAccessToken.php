<?php

namespace App\Models;

use App\Models\Traits\NoriaKeys;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    use HasFactory, SoftDeletes, NoriaKeys;

    const PREFIX = 'TKN';
}
