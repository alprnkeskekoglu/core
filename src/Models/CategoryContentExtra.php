<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryContentExtra extends Model
{
    protected $table = 'category_content_extras';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['id'];
}
