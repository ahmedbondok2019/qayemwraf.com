<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class users_api_tokens extends Model
{
    protected $table = 'users_api_tokens';

    protected $fillable = [
        'id', 'user_id', 'user_type', 'api_token', 'firebase_token', 'created_at', 'updated_at',
    ];
}
