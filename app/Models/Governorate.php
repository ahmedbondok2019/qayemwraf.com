<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Governorate extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the translations for the governorate.
     */
    public function translations()
    {
        return $this->hasMany(GovernorateTranslation::class);
    }

    /**
     * Get the translation for the current locale.
     */
    public function translation()
    {
        return $this->hasOne(GovernorateTranslation::class)->where('locale', app()->getLocale());
    }

    /**
     * Get the country associated with the governorate.
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Scope a query to only include active governorates.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Helper to get name in current locale
     */
    public function getNameAttribute()
    {
        return $this->translation->name ?? $this->translations->first()->name ?? '';
    }
}
