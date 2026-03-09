<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'is_default' => 'boolean',
        'status' => 'boolean',
        'exchange_rate' => 'double',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function translations()
    {
        return $this->hasMany(CurrencyTranslation::class);
    }

    public function translation()
    {
        return $this->hasOne(CurrencyTranslation::class)->where('locale', app()->getLocale());
    }

    public function getNameAttribute()
    {
        return $this->translation->name ?? $this->translations->first()->name ?? '';
    }

    public function getSymbolAttribute()
    {
        return $this->translation->symbol ?? $this->translations->first()->symbol ?? '';
    }
}
