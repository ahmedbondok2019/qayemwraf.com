<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductBrand extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the translations for the brand.
     */
    public function translations()
    {
        return $this->hasMany(ProductBrandTranslation::class);
    }

    /**
     * Get the translation for the current locale.
     */
    public function translation()
    {
        return $this->hasOne(ProductBrandTranslation::class)->where('locale', app()->getLocale());
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'product_brand_id');
    }

    /**
     * Scope a query to only include active brands.
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
        return $this->translation->title ?? $this->translations->first()->title ?? '';
    }
}
