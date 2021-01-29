<?php

namespace Dawnstar\Models;

use Dawnstar\FileManager\Models\Media;
use Dawnstar\Traits\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuContent extends BaseModel
{
    use SoftDeletes;
    use HasMedia;

    protected $table = 'menu_contents';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['id'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function children()
    {
        return $this->hasMany(MenuContent::class, 'parent_id', 'id');
    }

    public function url()
    {
        return $this->belongsTo(Url::class);
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

        if(method_exists($this, 'extras')) {
            $extras = $this->extras()->where('key', $key)->get();

            if($extras->isNotEmpty()) {
                if($extras->count() > 1) {
                    return $extras->pluck("value")->toArray();
                } else {
                    return $extras->first()->value;
                }
            }
        }

        if(\Str::startsWith($key, 'mf_')) {
            $mediaKey = mb_substr($key, 3);
            return $this->medias()->wherePivot('media_key', $mediaKey)->first();
        } elseif(\Str::startsWith($key, 'mc_')) {
            $mediaKey = mb_substr($key, 3);
            return $this->medias()->wherePivot('media_key', $mediaKey)->get();
        }

        return $attribute;
    }
}
