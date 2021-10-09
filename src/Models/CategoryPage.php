<?php

namespace Dawnstar\Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryPage extends BaseModel
{
    protected $table = 'category_pages';
    protected $fillable = ['category_id', 'page_id'];
}
