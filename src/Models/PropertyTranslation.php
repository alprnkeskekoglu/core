<?php

namespace Dawnstar\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyTranslation extends BaseModel
{
    use SoftDeletes;

    protected $table = 'property_translations';
    protected $guarded = ['id'];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
