<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the translations for the country.
     */
    public function translations()
    {
        return $this->hasMany(CountryTranslation::class);
    }

    /**
     * Get the translation for the current locale.
     */
    public function translation()
    {
        return $this->hasOne(CountryTranslation::class)->where('locale', app()->getLocale());
    }

    /**
     * Scope a query to only include active countries.
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
