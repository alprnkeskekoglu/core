<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Meta extends BaseModel
{
    protected $table = 'metas';
    protected $dates = ['created_at', 'updated_at'];

    protected $guarded = ['id'];

    public function url()
    {
        return $this->belongsTo(Url::class);
    }
}
