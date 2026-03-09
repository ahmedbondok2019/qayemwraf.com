<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the translations for the page.
     */
    public function translations()
    {
        return $this->hasMany(PageTranslation::class);
    }

    /**
     * Get the translation for the current locale.
     */
    public function translation()
    {
        return $this->hasOne(PageTranslation::class)->where('locale', app()->getLocale());
    }

    /**
     * Scope a query to only include active pages.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Helper to get title in current locale
     */
    public function getTitleAttribute()
    {
        return $this->translation->title ?? $this->translations->first()->title ?? '';
    }

    /**
     * Helper to get content in current locale
     */
    public function getContentAttribute()
    {
        return $this->translation->content ?? $this->translations->first()->content ?? '';
    }
}
