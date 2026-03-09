<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitLog extends Model
{
    protected $table = 'visit_logs';

    protected $guarded = [];

    protected $casts = [
        'raw' => 'array',
        'lat' => 'float',
        'lon' => 'float',
    ];
}
