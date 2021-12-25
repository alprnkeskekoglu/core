<?php

namespace Dawnstar\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageExtra extends BaseModel
{
    use SoftDeletes;

    protected $table = 'page_extras';
    protected $guarded = ['id'];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
