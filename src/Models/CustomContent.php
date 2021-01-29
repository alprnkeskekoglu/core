<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class CustomContent extends BaseModel
{
    use SoftDeletes;
    protected $table = 'custom_contents';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['id'];

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
