<?php

namespace Dawnstar\Core\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryProperty extends BaseModel
{
    protected $table = 'category_properties';
    protected $fillable = ['category_id', 'property_id'];
}
