<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Url extends BaseModel
{
    use SoftDeletes;

    protected $table = 'urls';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['id'];

    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function model()
    {
        return $this->morphTo(__FUNCTION__, 'model_type', 'model_id');
    }

    public function metas()
    {
        return $this->hasMany(Meta::class);
    }

    public function getMeta($key)
    {
        return $this->metas->where('key', $key)->first();
    }

    public function __toString()
    {
        return url($this->url);
    }
}
