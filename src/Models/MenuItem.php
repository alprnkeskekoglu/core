<?php

namespace Dawnstar\Core\Models;

use Dawnstar\MediaManager\Traits\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuItem extends BaseModel
{
    use SoftDeletes, HasMedia;

    protected $table = 'menu_items';
    protected $guarded = ['id'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id', 'id');
    }

    public function url()
    {
        return $this->belongsTo(Url::class);
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
