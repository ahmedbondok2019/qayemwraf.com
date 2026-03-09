<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function translations()
    {
        return $this->hasMany(OptionTranslation::class);
    }

    public function translation()
    {
        return $this->hasOne(OptionTranslation::class)->where('locale', app()->getLocale());
    }

    public function values()
    {
        return $this->hasMany(OptionValue::class)->orderBy('sort_order');
    }

    public function getNameAttribute()
    {
        return $this->translation->name ?? $this->translations->first()->name ?? '';
    }
}
