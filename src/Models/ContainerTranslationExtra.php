<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContainerTranslationExtra extends BaseModel
{
    use SoftDeletes;

    protected $table = 'container_translation_extras';
    protected $guarded = ['id'];

    public function translation()
    {
        return $this->belongsTo(ContainerTranslation::class);
    }
}
