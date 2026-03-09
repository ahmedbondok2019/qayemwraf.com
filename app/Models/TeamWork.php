<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeamWork extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function translations()
    {
        return $this->hasOne(TeamWorkTranslation::class, 'team_work_id')->where('lang_id', app()->getLocale());
    }

    public function images()
    {
        return $this->hasMany(TeamWorkImage::class, 'team_work_id');
    }
}
