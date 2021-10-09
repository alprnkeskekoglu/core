<?php

namespace Dawnstar\Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;

class MetaTag extends BaseModel
{
    protected $table = 'meta_tags';
    protected $guarded = ['id'];

    public function url()
    {
        return $this->belongsTo(Url::class);
    }
}
