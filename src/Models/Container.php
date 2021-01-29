<?php

namespace Dawnstar\Models;

use Dawnstar\FileManager\Models\Media;
use Dawnstar\Traits\HasDetail;
use Dawnstar\Traits\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;

class Container extends BaseModel
{
    use SoftDeletes;
    use HasDetail;
    use HasMedia;

    protected $table = 'containers';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['id'];


    public function details()
    {
        return $this->hasMany(ContainerDetail::class);
    }

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function languages()
    {
        $detailLanguageIds = $this->details()->where('status', 1)->get()->pluck('language_id')->toArray();
        return Language::whereIn('id', $detailLanguageIds)->get();
    }
}
