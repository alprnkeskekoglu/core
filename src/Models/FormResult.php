<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormResult extends Model
{
    use SoftDeletes;
    protected $table = 'form_results';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [
        'data' => 'array'
    ];

    protected $guarded = ['id'];
}
