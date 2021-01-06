<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuContent extends Model
{
    use SoftDeletes;

    protected $table = 'menu_contents';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['id'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function children()
    {
        return $this->hasMany(MenuContent::class, 'parent_id', 'id');
    }

    public function url()
    {
        return $this->belongsTo(Url::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
