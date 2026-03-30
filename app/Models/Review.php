<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory;
    use SoftDeletes;
    use \App\Traits\HandleImageStorageTrait;

    protected $guarded = [];

    public function ReviewTranslation()
    {
        return $this->hasOne(ReviewTranslation::class)->where('lang_id', app()->getLocale());
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1)->orderBy('view_index');
    }
}
