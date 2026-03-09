<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionValue extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function translations()
    {
        return $this->hasMany(OptionValueTranslation::class);
    }

    public function translation()
    {
        return $this->hasOne(OptionValueTranslation::class)->where('locale', app()->getLocale());
    }

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function productOptionValues()
    {
        return $this->hasMany(ProductOptionValue::class);
    }

    public function getValueAttribute()
    {
        return $this->translation->value ?? $this->translations->first()->value ?? '';
    }
}
