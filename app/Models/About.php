<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class About extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function AboutTranslation()
    {
        return $this->hasOne(AboutTranslation::class)->where('lang_id', app()->getLocale());
    }

    public function AboutImages()
    {
        return $this->hasMany(AboutImage::class, 'about_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1)->orderBy('view_index');
    }
}
