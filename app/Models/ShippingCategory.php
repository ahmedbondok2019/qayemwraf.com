<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShippingCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function translations()
    {
        return $this->hasMany(ShippingCategoryTranslation::class)->where('lang_id', app()->getLocale());
    }

    public function areas()
    {
        return $this->hasMany(ShippingCategoryArea::class);
    }
}
