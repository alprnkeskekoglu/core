<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Website extends BaseModel
{
    use SoftDeletes;
    protected $table = 'websites';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['id'];

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'website_languages');
    }

    public function defaultLanguage(): Language
    {
        return $this->belongsToMany(Language::class, 'website_languages')->wherePivot('is_default', 1)->first();
    }
}
