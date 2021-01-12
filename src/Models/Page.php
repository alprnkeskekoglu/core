<?php

namespace Dawnstar\Models;

use Dawnstar\Traits\HasDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes;
    use HasDetail;

    protected $table = 'pages';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['id'];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function details()
    {
        return $this->hasMany(PageDetail::class);
    }

    public function extras()
    {
        return $this->hasMany(PageExtra::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_pages');
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
