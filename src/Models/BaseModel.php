<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function syncMedias(array $medias)
    {
        dd($this);
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
