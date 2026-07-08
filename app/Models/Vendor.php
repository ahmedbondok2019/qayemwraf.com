<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Vendor extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use \App\Traits\HandleImageStorageTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'full_name',
        'phone',
        'category',
        'email',
        'image',
        'address',
        'area_id',
        'city_id',
        'website',
        'status',
        'profit_group',
        'password',
        'bank_name',
        'bank_iban',
        'account_type',
        'commerical_license',
        'tax_license',
        'identity_card1',
        'identity_card2',
        'address_prove',
        'commerical_license_status',
        'tax_license_status',
        'identity_card1_status',
        'identity_card2_status',
        'address_prove_status',
        'contract',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = ['email_verified_at' => 'datetime'];

    protected $dates = ['birth_date'];

    public function VendorImages()
    {
        return $this->hasMany(VendorImage::class, 'vendor_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class)->where('status', 1);
    }
}
