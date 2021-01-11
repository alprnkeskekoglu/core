<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageDetail extends Model
{
    use SoftDeletes;
    protected $table = 'page_details';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['id'];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function extras()
    {
        return $this->hasMany(PageDetailExtra::class);
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
