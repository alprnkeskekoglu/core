<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Form extends Model
{
    use SoftDeletes;
    protected $table = 'forms';

    protected $fillable = [
        'name',
        'slug',
        'sender',
        'receivers',
        'recaptcha_status',
        'recaptcha_site_key',
        'recaptcha_secret_key',
    ];
}
