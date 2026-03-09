<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingRule extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function translations()
    {
        return $this->hasMany(ShippingRuleTranslation::class);
    }

    public function translation()
    {
        return $this->hasOne(ShippingRuleTranslation::class)->where('locale', app()->getLocale());
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function governorateRates()
    {
        return $this->hasMany(ShippingRuleGovernorate::class);
    }

    public function getNameAttribute()
    {
        return $this->translation->name ?? $this->translations->first()->name ?? '';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
