<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteLanguage extends BaseModel
{
    protected $table = 'website_languages';
    protected $fillable = ['website_id', 'language_id'];
}
