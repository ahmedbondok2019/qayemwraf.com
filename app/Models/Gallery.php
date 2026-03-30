<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{
    use HasFactory;
    use SoftDeletes;
    use \App\Traits\HandleImageStorageTrait;

    protected $guarded = [];

    public function GalleryTranslation()
    {
        return $this->hasOne(GalleryTranslation::class, 'gallery_id', 'id')->where('lang_id', app()->getLocale());
    }

    public function GalleryImages()
    {
        return $this->hasMany(GalleryImage::class, 'gallery_id', 'id');
    }

    public function GalleryVideos()
    {
        return $this->hasMany(GalleryVideo::class, 'gallery_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1)->orderBy('view_index');
    }
}
