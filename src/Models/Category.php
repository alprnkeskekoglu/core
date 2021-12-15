<?php

namespace Dawnstar\Models;

use Dawnstar\MediaManager\Traits\HasMedia;
use Dawnstar\Traits\HasTranslation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends BaseModel
{
    use SoftDeletes, HasMedia, HasTranslation;

    protected $table = 'categories';
    protected $guarded = ['id'];

    public function structure()
    {
        return $this->belongsTo(Structure::class);
    }

    public function container()
    {
        return $this->belongsTo(Container::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'id', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function translations()
    {
        return $this->hasMany(CategoryTranslation::class);
    }

    public function properties()
    {
        return $this->belongsToMany(Property::class, 'category_properties');
    }

    public function pages()
    {
        return $this->belongsToMany(Page::class, 'category_pages');
    }
}
