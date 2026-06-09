<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class ApiUser extends Model
{
    use HasApiTokens;

    protected $table = 'api_users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'app_name',
        'app_description',
        'status',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}