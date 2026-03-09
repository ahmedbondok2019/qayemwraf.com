<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the translations for the offer.
     */
    public function translations()
    {
        return $this->hasMany(OfferTranslation::class);
    }

    /**
     * Alias for translations() to support legacy code.
     */
    public function offer_translations()
    {
        return $this->translations();
    }

    /**
     * Get the translation for the current locale.
     */
    public function translation()
    {
        return $this->hasOne(OfferTranslation::class)->where('locale', app()->getLocale());
    }

    /**
     * Get the category associated with the offer.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Scope a query to only include active offers.
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
