<?php

namespace Dawnstar\Core\Models;

use Dawnstar\MediaManager\Traits\HasMedia;
use Dawnstar\Core\Traits\HasTranslation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Container extends BaseModel
{
    use SoftDeletes, HasTranslation, HasMedia;

    protected $table = 'containers';
    protected $guarded = ['id'];

    public function structure()
    {
        return $this->belongsTo(Structure::class);
    }

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function translations()
    {
        return $this->hasMany(ContainerTranslation::class);
    }

    public function customPages(string $key = null)
    {
        $pages = $this->belongsToMany(Page::class, 'container_pages');

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
