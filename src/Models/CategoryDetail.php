<?php

namespace Dawnstar\Models;

use Dawnstar\FileManager\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryDetail extends Model
{
    use SoftDeletes;
    protected $table = 'category_details';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class,'category_id', 'id');
    }

    public function extras()
    {
        return $this->hasMany(CategoryDetailExtra::class);
    }

    public function medias()
    {
        return $this->morphToMany(Media::class, 'model', 'model_medias');
    }

    public function url()
    {
        return $this->morphOne(Url::class, 'model', 'model_class', 'model_id')->withDefault(['url' => '/']);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function __get($key)
    {
        $attribute = $this->getAttribute($key);

        if ($attribute) {
            return $attribute;
        }

        $extras = $this->extras()->where('key', $key)->get();

        if($extras->isNotEmpty()) {
            if($extras->count() > 1) {
                return $extras->pluck("value")->toArray();
            } else {
                return $extras->first()->value;
            }
        }
        return $attribute;
    }
}
