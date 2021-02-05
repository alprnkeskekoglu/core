<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class SearchData extends BaseModel
{
    protected $table = 'search_data';

    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function url()
    {
        return $this->hasOne(Url::class, 'id', 'url_id');
    }
    public function model()
    {
        return $this->morphTo();
    }
}
