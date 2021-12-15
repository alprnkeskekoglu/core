<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;

class ContainerPage extends BaseModel
{
    protected $table = 'container_pages';
    protected $fillable = ['container_id', 'page_id'];
}
