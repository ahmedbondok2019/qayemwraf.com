<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['blog_category_id', 'status', 'view_index'];
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public function BlogTranslation()
    {
        return $this->hasOne(BlogTranslation::class)->where('lang_id', app()->getLocale());
    }

    public function BlogComments()
    {
        return $this->hasMany(BlogComment::class)->where('lang_id', app()->getLocale())->where('status', 1);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1)->orderBy('view_index');
    }

    protected $rules = [
        'title' => 'sometimes|required|email|unique:blog_translations',
    ];
}
