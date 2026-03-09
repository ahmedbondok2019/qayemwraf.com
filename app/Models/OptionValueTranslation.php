<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionValueTranslation extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function optionValue()
    {
        return $this->belongsTo(OptionValue::class);
    }
}
