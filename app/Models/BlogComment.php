<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogComment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function BlogComments()
    {
        return $this->belongsTo(Blog::class)->where('lang_id', app()->getLocale());
    }
}
