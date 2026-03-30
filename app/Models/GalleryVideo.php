<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GalleryVideo extends Model
{
    use HasFactory;
    use SoftDeletes;
    use \App\Traits\HandleImageStorageTrait;

    protected $guarded = [];
}
