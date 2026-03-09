<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OptionItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function translations()
    {
        return $this->hasMany(OptionItemTranslation::class)->where('lang_id', app()->getLocale());
    }

    public function trans($lang)
    {
        return $this->hasOne(OptionItemTranslation::class)->where('lang_id', $lang);
    }

    public function Dashtranslations()
    {
        return $this->hasMany(OptionItemTranslation::class);
    }
}
