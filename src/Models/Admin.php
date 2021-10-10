<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use SoftDeletes;

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
}
