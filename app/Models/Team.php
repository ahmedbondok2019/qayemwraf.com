<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function TeamTranslation()
    {
        return $this->hasOne(TeamTranslation::class, 'team_id', 'id')->where('lang_id', app()->getLocale());
    }

    public function TeamImages()
    {
        return $this->hasMany(TeamImage::class, 'team_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1)->orderBy('view_index');
    }
}
