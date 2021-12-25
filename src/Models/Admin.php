<?php

namespace Dawnstar\Core\Models;

use Dawnstar\Core\MediaManager\Traits\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use SoftDeletes, HasMedia, HasRoles;

    protected $table = 'admins';
    protected $guarded = ['id'];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function actions()
    {
        return $this->hasMany(AdminAction::class);
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
