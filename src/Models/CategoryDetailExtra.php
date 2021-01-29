<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryDetailExtra extends BaseModel
{
    protected $table = 'category_detail_extras';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['id'];

}
