<?php

namespace Dawnstar\Models;

use Dawnstar\FileManager\Models\Media;
use Dawnstar\Traits\HasDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    use HasDetail;
    protected $table = 'categories';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['id'];

    public function container()
    {
        return $this->belongsTo(Container::class);
    }

    public function details()
    {
        return $this->hasMany(CategoryDetail::class);
    }

    public function medias()
    {
        return $this->morphToMany(Media::class, 'model', 'model_medias');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function pages()
    {
        return $this->belongsToMany(Page::class, 'category_pages');
    }
}
