<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderService extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
