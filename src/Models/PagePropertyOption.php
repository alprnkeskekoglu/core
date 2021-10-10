<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;

class PagePropertyOption extends BaseModel
{
    protected $table = 'page_property_options';
    protected $fillable = ['page_id', 'property_option_id'];
}
