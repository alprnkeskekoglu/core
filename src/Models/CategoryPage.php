<?php

namespace Dawnstar\Models;


class CategoryPage extends BaseModel
{
    protected $table = 'category_pages';
    public $timestamps = false;

    public $fillable = ['category_id', 'page_id'];
}
