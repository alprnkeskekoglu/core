<?php

namespace Dawnstar\Models;

use Dawnstar\MediaManager\Traits\HasMedia;
use Dawnstar\Traits\HasTranslation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends BaseModel
{
    use SoftDeletes, HasTranslation, HasMedia;

    protected $table = 'pages';
    protected $guarded = ['id'];

    public function container()
    {
        return $this->belongsTo(Container::class);
    }

    public function parent()
    {
        return $this->belongsTo(Page::class, 'id', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Page::class, 'parent_id', 'id');
    }

    public function translations()
    {
        return $this->hasMany(PageTranslation::class);
    }

    public function extras()
    {
        return $this->hasMany(PageExtra::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_pages');
    }

    public function category()
    {
        return $this->categories()->first();
    }

    public function propertyOptions()
    {
        return $this->belongsToMany(PropertyOption::class, 'page_property_options');
    }

    public function __get($key)
    {
        $attribute = $this->getAttribute($key);

        $return = null;

        if ($attribute) {
            $return = $attribute;
        } elseif (method_exists($this, 'extras')) {
            $extras = $this->extras()->where('key', $key)->get();
            if ($extras->isNotEmpty()) {
                if ($extras->count() > 1) {
                    $return = $extras->pluck("value")->toArray();
                } else {
                    $return = $extras->first()->value;
                }
            }
        }

        return $return;
    }
}
