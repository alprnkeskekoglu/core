<?php

namespace Dawnstar\Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryTranslationExtra extends BaseModel
{
    use SoftDeletes;

    protected $table = 'category_translation_extras';
    protected $guarded = ['id'];

    public function translation()
    {
        return $this->belongsTo(CategoryTranslation::class);
    }
}
