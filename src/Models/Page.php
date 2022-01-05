<?php

namespace Dawnstar\Core\Models;

use Dawnstar\MediaManager\Traits\HasMedia;
use Dawnstar\Core\Traits\HasTranslation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends BaseModel
{
    use SoftDeletes, HasTranslation, HasMedia;

    protected $table = 'pages';
    protected $guarded = ['id'];

    public function structure()
    {
        return $this->belongsTo(Structure::class);
    }

    public function container()
    {
        return $this->belongsTo(Container::class);
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

    public function customPages(string $key = null)
    {
        $pages = $this->belongsToMany(Page::class, 'page_relations', 'locale_id', 'foreign_id');

        if($key) {
            $pages = $pages->wherePivot('key', $key);
        }

        return $pages;
    }

    public function __get($key)
    {
        $attribute = $this->getAttribute($key);

        if ($attribute) {
            return $attribute;
        }

        if (method_exists($this, 'extras')) {
            $extras = $this->extras()->where('key', $key)->get();
            if ($extras->isNotEmpty()) {
                if ($extras->count() > 1) {
                    return $extras->pluck("value")->toArray();
                } else {
                    return $extras->first()->value;
                }
            }
        }

        if (method_exists($this, 'extras')) {
            if(\Str::startsWith($key, 'mf_')) {
                $key = mb_substr($key, 3);
                $medias = $this->medias();
                if($key) {
                    $medias->wherePivot('key', $key);
                }
                return $medias->orderBy('model_medias.order')->first();
            } elseif(\Str::startsWith($key, 'mc_')) {
                $key = mb_substr($key, 3);
                $medias = $this->medias();
                if($key) {
                    $medias->wherePivot('key', $key);
                }
                return $medias->orderBy('model_medias.order')->get();
            }
        }

        return $attribute;
    }
}
