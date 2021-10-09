<?php

namespace Dawnstar\Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContainerTranslation extends BaseModel
{
    use SoftDeletes;

    protected $table = 'container_translations';
    protected $guarded = ['id'];

    public function container()
    {
        return $this->belongsTo(Container::class);
    }

    public function parent()
    {
        return $this->belongsTo(Container::class);
    }

    public function extras()
    {
        return $this->hasMany(ContainerTranslationExtra::class);
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
