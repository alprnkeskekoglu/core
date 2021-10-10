<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyOptionTranslation extends BaseModel
{
    use SoftDeletes;

    protected $table = 'property_option_translations';
    protected $guarded = ['id'];

    public function propertyOption()
    {
        return $this->belongsTo(PropertyOption::class);
    }
}
