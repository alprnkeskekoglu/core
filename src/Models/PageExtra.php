<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class PageExtra extends BaseModel
{
    protected $table = 'page_extras';
    protected $dates = ['created_at', 'updated_at'];

    protected $guarded = ['id'];
}
