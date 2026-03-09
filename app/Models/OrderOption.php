<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderOption extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function optionItem()
    {
        return $this->belongsTo(OptionItem::class);
    }

    public function optionTranslation()
    {
        return $this->hasOne(OptionTranslation::class, 'option_id', 'option_id')
            ->where('lang_id', app()->getLocale());
    }

    public function optionItemTranslation()
    {
        return $this->hasOne(OptionItemTranslation::class, 'option_item_id', 'option_item_id')
            ->where('lang_id', app()->getLocale());
    }
}
