<?php

namespace Dawnstar\Core\Models;

use Dawnstar\MediaManager\Traits\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuItem extends BaseModel
{
    use SoftDeletes, HasMedia;

    protected $table = 'menu_items';
    protected $guarded = ['id'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id', 'id');
    }

    public function url()
    {
        return $this->belongsTo(Url::class);
    }
}
