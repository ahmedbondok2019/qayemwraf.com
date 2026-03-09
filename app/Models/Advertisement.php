<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advertisement extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function translations()
    {
        return $this->hasMany(AdvertisementTranslation::class);
    }

    public function translate($locale)
    {
        return $this->translations->firstWhere('locale', $locale);
    }

    public function translation()
    {
        return $this->hasOne(AdvertisementTranslation::class)->where('locale', app()->getLocale());
    }

    public function getImageAttribute()
    {
        return $this->translation->image ?? $this->translations->first()->image ?? '';
    }

    public function getLinkAttribute()
    {
        return $this->translation->link ?? $this->translations->first()->link ?? '';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where(function ($q) {
                         $q->whereNull('start_at')->orWhere('start_at', '<=', now());
                     })
                     ->where(function ($q) {
                         $q->whereNull('end_at')->orWhere('end_at', '>=', now());
                     });
    }
}
