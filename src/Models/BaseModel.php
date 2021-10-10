<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
