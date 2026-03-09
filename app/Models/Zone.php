<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zone extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function translations()
    {
        return $this->hasMany(ZoneTranslation::class)->where('lang_id', app()->getLocale());
    }
}
