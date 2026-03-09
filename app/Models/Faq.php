<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function FaqTranslation()
    {
        return $this->hasOne(FaqTranslation::class, 'faq_id', 'id')->where('lang_id', app()->getLocale());
    }
}
