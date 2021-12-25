<?php

namespace Dawnstar\Core\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public static function boot()
    {
        static::created(function ($model) {
            adminAction($model, 'store');
        });

        static::saved(function ($model) {
            adminAction($model, 'store');
        });

        static::updated(function ($model) {
            adminAction($model, 'update');
        });

        static::deleted(function ($model) {
            adminAction($model, 'destroy');
        });

        parent::boot();
    }
  
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeWebsite($query)
    {
        return $query->where('website_id', session('dawnstar.website.id'));
    }

    public function syncMedias(array $medias)
    {
        foreach ($medias as $key => $media_ids) {
            $media_ids = explode(',', $media_ids);
            $save = [];
            foreach ($media_ids as $media_id) {
                $save[$media_id] = ['key' => $key];
            }
            $this->medias()->sync($save);
        }
    }
}
