<?php

namespace App\Models;

use App\Traits\HandleImageStorageTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogTranslation extends Model
{
    use HandleImageStorageTrait;
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    /**
     * Get card image (outer image) with fallback to default image.
     */
    public function getCardImageAttribute($value)
    {
        return $value ?: $this->attributes['image'] ?? null;
    }

    /**
     * Get inner image (inside article image) with fallback to default image.
     */
    public function getInnerImageAttribute($value)
    {
        return $value ?: $this->attributes['image'] ?? null;
    }
}
