<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public $timestamps = true;

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, GroupPermission::class, 'group_id', 'permission_id', 'id', 'id');
    }

    public function permission()
    {
        return $this->hasMany(GroupPermission::class);
    }
}
