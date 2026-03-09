<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function translations()
    {
        return $this->hasMany(SliderTranslation::class);
    }

    public function translation()
    {
        return $this->hasOne(SliderTranslation::class)->where('locale', app()->getLocale());
    }

    /**
     * Alias for translation() to support legacy code.
     */
    public function SliderTranslation()
    {
        return $this->translation();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function getNameAttribute()
    {
        return $this->translation->title ?? $this->translations->first()->title ?? '';
    }
}
