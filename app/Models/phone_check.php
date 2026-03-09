<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class phone_check extends Model
{
    protected $table = 'phone_check';

    protected $fillable = ['id', 'phone', 'check_code', 'created_at', 'updated_at'];
}
