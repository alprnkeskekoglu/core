<?php

namespace Dawnstar\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends BaseModel
{
    /* Types
     * 1 => 'Inner'
     * 2 => 'Outer'
     * 3 => 'Empty'
     */

    use SoftDeletes;

    protected $table = 'menus';
    protected $guarded = ['id'];

    public function items()
    {
        return $this->hasMany(MenuItem::class);
    }
}
