<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class FormResult extends BaseModel
{
    use SoftDeletes;
    protected $table = 'form_results';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [
        'data' => 'array'
    ];

    protected $guarded = ['id'];
}
