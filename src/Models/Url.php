<?php

namespace Dawnstar\Core\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Model $model
 */
class Url extends BaseModel
{
    /* Types
     * 1 => 'original'
     * 2 => 'redirect'
     */

    protected $table = 'urls';
    protected $guarded = ['id'];

    public function model()
    {
        return $this->morphTo('model');
    }

    public function metas()
    {
        return $this->hasMany(MetaTag::class);
    }

    public function __toString()
    {
        return url($this->url);
    }
}
