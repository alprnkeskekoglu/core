<?php

namespace Dawnstar\Models;

use Dawnstar\FileManager\Models\Media;
use Dawnstar\Traits\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContainerDetail extends BaseModel
{
    use SoftDeletes;
    use HasMedia;

    protected $table = 'container_details';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['id'];

    public function container()
    {
        return $this->belongsTo(Container::class);
    }

    public function extras()
    {
        return $this->hasMany(ContainerDetailExtra::class);
    }

    public function url()
    {
        return $this->morphOne(Url::class, 'model', 'model_type', 'model_id')->withDefault(['url' => '/']);
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
            $medias = $this->medias();
            if($mediaKey) {
                $medias->wherePivot('media_key', $mediaKey);
            }
            return $medias->first();
        } elseif(\Str::startsWith($key, 'mc_')) {
            $mediaKey = mb_substr($key, 3);
            $medias = $this->medias();
            if($mediaKey) {
                $medias->wherePivot('media_key', $mediaKey);
            }
            return $medias->get();
        }

        return $attribute;
    }
}
