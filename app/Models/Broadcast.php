<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Broadcast extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'image',
        'link',
        'audience',
        'channels',
        'status',
        'scheduled_at',
        'sent_count',
        'failed_count',
        'clicks_count',
    ];

    protected $casts = [
        'channels' => 'array',
        'scheduled_at' => 'datetime',
    ];
}
