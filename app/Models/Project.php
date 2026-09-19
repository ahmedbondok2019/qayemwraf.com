<?php

namespace App\Models;

use App\Traits\HandleImageStorageTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HandleImageStorageTrait;
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function translations()
    {
        return $this->hasMany(ProjectTranslation::class);
    }

    public function translation()
    {
        return $this->hasOne(ProjectTranslation::class)->where('locale', app()->getLocale());
    }

    public function ProjectTranslation()
    {
        return $this->translation();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order', 'asc')->orderBy('id', 'desc');
    }

    public function getTitleAttribute()
    {
        return $this->translation->title ?? $this->translations->first()->title ?? '';
    }

    public function getDescriptionAttribute()
    {
        return $this->translation->description ?? $this->translations->first()->description ?? '';
    }
}
