<?php

namespace Dawnstar\Models;

use Dawnstar\FileManager\Models\Media;
use Dawnstar\Traits\HasDetail;
use Dawnstar\Traits\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;

class Container extends BaseModel
{
    use SoftDeletes;
    use HasDetail;
    use HasMedia;

    protected $table = 'containers';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['id'];


    public function details()
    {
        return $this->hasMany(ContainerDetail::class);
    }

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function languages()
    {
        $detailLanguageIds = $this->details()->where('status', 1)->get()->pluck('language_id')->toArray();
        return Language::whereIn('id', $detailLanguageIds)->get();
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function formBuilders()
    {
        return $this->hasMany(FormBuilder::class);
    }

    public function __get($key)
    {
        $attribute = $this->getAttribute($key);

        if ($attribute) {
            return $attribute;
        }

        if(\Str::startsWith($key, 'mf_')) {
            $mediaKey = mb_substr($key, 3);

            $medias = $this->medias();
            if($mediaKey) {
                $medias->wherePivot('media_key', $mediaKey);
            }
            return $medias->orderBy('model_medias.order')->first();
        } elseif(\Str::startsWith($key, 'mc_')) {
            $mediaKey = mb_substr($key, 3);
            $medias = $this->medias();
            if($mediaKey) {
                $medias->wherePivot('media_key', $mediaKey);
            }
            return $medias->orderBy('model_medias.order')->get();
        }

        return $attribute;
    }
}
