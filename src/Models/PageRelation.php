<?php

namespace Dawnstar\Core\Models;

use Illuminate\Database\Eloquent\Model;

class PageRelation extends BaseModel
{
    protected $table = 'page_relations';
    protected $fillable = ['locale_id', 'foreign_id'];
}
