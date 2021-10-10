<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;

class Url extends BaseModel
{
    protected $table = 'urls';
    protected $guarded = ['id'];

    public function model()
    {
        return $this->morphTo('model');
    }

    public function __toString()
    {
        return url($this->url);
    }
}
