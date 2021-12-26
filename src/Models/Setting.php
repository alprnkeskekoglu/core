<?php

namespace Dawnstar\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';
    protected $guarded = ['id'];
}
