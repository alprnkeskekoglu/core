<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Website extends BaseModel
{
    use SoftDeletes;

    protected $table = 'websites';
    protected $guarded = ['id'];

    public function structures()
    {
        return $this->hasMany(Structure::class);
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'website_languages');
    }

    public function defaultLanguage()
    {
        return $this->belongsToMany(Language::class, 'website_languages')->wherePivot('default', 1)->first();
    }
}
