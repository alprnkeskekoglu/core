<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyOption extends BaseModel
{
    use SoftDeletes;

    protected $table = 'property_options';
    protected $guarded = ['id'];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function translations()
    {
        return $this->hasMany(PropertyOptionTranslation::class);
    }

    public function pages()
    {
        return $this->belongsToMany(Page::class, 'page_property_options');
    }
}
