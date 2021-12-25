<?php

namespace Dawnstar\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageTranslationExtra extends BaseModel
{
    use SoftDeletes;

    protected $table = 'page_translation_extras';
    protected $guarded = ['id'];

    public function translation()
    {
        return $this->belongsTo(PageTranslation::class);
    }
}
