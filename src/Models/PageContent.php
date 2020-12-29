<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageContent extends Model
{
    use SoftDeletes;
    protected $table = 'page_contents';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['id'];
}
