<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaticTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'translations',
    ];

    protected $casts = [
        'translations' => 'array',
    ];
}
