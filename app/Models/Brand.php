<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function BrandTranslations()
    {
        return $this->hasOne(BrandTranslation::class)->where('lang_id', app()->getLocale());
    }

    public function products()
    {
        return $this->hasMany(Product::class)->where('status', 1)->where('lang_id', app()->getLocale());
    }
}
