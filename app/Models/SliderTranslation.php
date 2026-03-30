<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SliderTranslation extends Model
{
    use HasFactory;
    use SoftDeletes;
    use \App\Traits\HandleImageStorageTrait;

    protected $guarded = [];

    public $timestamps = false;

    public function slider()
    {
        return $this->belongsTo(Slider::class);
    }
}
