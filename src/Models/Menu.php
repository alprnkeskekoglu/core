<?php

namespace Dawnstar\Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends BaseModel
{
    use SoftDeletes;

    protected $table = 'menus';
    protected $guarded = ['id'];

    public function items()
    {
        return $this->hasMany(MenuItem::class);
    }
}
