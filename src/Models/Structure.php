<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Structure extends BaseModel
{
    use SoftDeletes;

    protected $table = 'structures';
    protected $guarded = ['id'];

    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function container()
    {
        return $this->hasOne(Container::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function moduleBuilders()
    {
        return $this->hasMany(ModuleBuilder::class);
    }
}
