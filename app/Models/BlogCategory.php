<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function translation()
    {
        return $this->hasOne(BlogCategoryTranslation::class)->where('lang_id', app()->getLocale());
    }

    public function translations()
    {
        return $this->hasMany(BlogCategoryTranslation::class);
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }
}
