<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes;
    protected $table = 'pages';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['id'];
}
