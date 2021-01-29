<?php

namespace Dawnstar\Models;

class WebsiteLanguage extends BaseModel
{
    protected $table = 'website_languages';
    protected $dates = ['created_at', 'updated_at'];

    protected $guarded = ['id'];
}
