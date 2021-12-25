<?php

namespace Dawnstar\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomTranslation extends BaseModel
{
    use SoftDeletes;
    
    protected $table = 'custom_translations';
    protected $guarded = ['id'];

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
