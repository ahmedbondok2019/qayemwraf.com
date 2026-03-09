<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rate extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->where('status', 1)->orderBy('view_index');
    }
}
