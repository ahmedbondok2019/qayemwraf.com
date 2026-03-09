<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAddress extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'address',
        'country_id',
        'governorate_id',
        'city_id',
        'lat',
        'lng',
        'is_main',
    ];

    protected $casts = [
        'is_main' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function country_rel()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function governorate_rel()
    {
        return $this->belongsTo(Governorate::class, 'governorate_id');
    }

    public function city_rel()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
