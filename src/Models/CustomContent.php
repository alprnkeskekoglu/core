<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomContent extends Model
{
    use SoftDeletes;
    protected $table = 'custom_contents';

    protected $fillable = [
        'language_id',
        'key',
        'value',
    ];
}
