<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GovernorateTranslation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function governorate()
    {
        return $this->belongsTo(Governorate::class);
    }
}
