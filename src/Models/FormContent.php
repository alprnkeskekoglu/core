<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormContent extends Model
{
    use SoftDeletes;
    protected $table = 'form_contents';

    protected $fillable = [
        'form_id',
        'email',
        'read',
        'ip',
        'user_agent',
        'data',
    ];
}
