<?php

namespace Dawnstar\Models;


class Language extends BaseModel
{
    protected $table = 'languages';
    public $timestamps = false;

    protected $guarded = ['id'];
}
