<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'tax' => 'decimal:2',
    ];

    /**
     * Get the translations for the payment method.
     */
    public function translations()
    {
        return $this->hasMany(PaymentMethodTranslation::class);
    }

    /**
     * Get the translation for the current locale.
     */
    public function translation()
    {
        return $this->hasOne(PaymentMethodTranslation::class)->where('locale', app()->getLocale());
    }

    /**
     * Scope a query to only include active payment methods.
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

    /**
     * Helper to get description in current locale
     */
    public function getDescriptionAttribute()
    {
        return $this->translation->description ?? $this->translations->first()->description ?? '';
    }
}
