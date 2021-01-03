<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageDetailExtra extends Model
{
    protected $table = 'page_detail_extras';
    protected $dates = ['created_at', 'updated_at'];

    protected $guarded = ['id'];
}
