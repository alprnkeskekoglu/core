<?php

namespace Dawnstar\Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends BaseModel
{
    use SoftDeletes;

    protected $table = 'properties';
    protected $guarded = ['id'];

    public function container()
    {
        return $this->belongsTo(Container::class);
    }

    public function translations()
    {
        return $this->hasMany(PropertyTranslation::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_properties');
    }
}
