<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends BaseModel
{
    use SoftDeletes;
    protected $table = 'menus';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['id'];

    public function contents()
    {
        return $this->hasMany(MenuContent::class);
    }
}
