<?php

namespace Dawnstar\Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryProperty extends BaseModel
{
    protected $table = 'category_property';
    protected $fillable = ['category_id', 'property_id'];
}
