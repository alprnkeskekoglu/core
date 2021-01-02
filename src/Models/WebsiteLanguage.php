<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteLanguage extends Model
{
    protected $table = 'website_languages';
    protected $dates = ['created_at', 'updated_at'];

    protected $guarded = ['id'];
}
