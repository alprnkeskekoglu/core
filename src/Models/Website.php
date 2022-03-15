<?php

namespace Dawnstar\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 */
class Website extends Model
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
        return $this->belongsToMany(Language::class, 'website_languages')->withPivot('default')->orderByDesc('pivot_default');
    }

    public function defaultLanguage()
    {
        return $this->belongsToMany(Language::class, 'website_languages')->wherePivot('default', 1)->first();
    }
}
