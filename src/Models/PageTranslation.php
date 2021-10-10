<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageTranslation extends BaseModel
{
    use SoftDeletes;

    protected $table = 'page_translations';
    protected $guarded = ['id'];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function extras()
    {
        return $this->hasMany(PageTranslationExtra::class);
    }

    public function url()
    {
        return $this->morphOne(Url::class, 'model');
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
