<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShippingCategoryArea extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function area()
    {
        return $this->hasOne(AreaTranslation::class, 'area_id', 'area_id')->where('lang_id', app()->getLocale());
    }
}
