<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;

class CustomTranslation extends BaseModel
{
    protected $table = 'custom_translations';
    protected $guarded = ['id'];

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
