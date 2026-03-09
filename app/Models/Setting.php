<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'app_name' => 'array',
        'app_meta_title' => 'array',
        'app_meta_desc' => 'array',
        'address' => 'array',
        'msg_processing' => 'array',
        'msg_shipped' => 'array',
        'msg_completed' => 'array',
        'msg_cancelled' => 'array',
        'msg_delivered' => 'array',
        'facebook_client_id' => 'string',
        'facebook_client_secret' => 'string',
        'facebook_redirect' => 'string',
        'google_client_id' => 'string',
        'google_client_secret' => 'string',
        'google_redirect' => 'string',
        'show_ratings' => 'boolean',
        'enable_reviews' => 'boolean',
    ];

    public function translate($attribute, $locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        $value = $this->{$attribute};

        if (is_array($value)) {
            return $value[$locale] ?? $value['en'] ?? $value[array_key_first($value)] ?? '';
        }

        return $value;
    }
}
