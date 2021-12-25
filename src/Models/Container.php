<?php

namespace Dawnstar\Core\Models;

use Dawnstar\Core\MediaManager\Traits\HasMedia;
use Dawnstar\Core\Traits\HasTranslation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Container extends BaseModel
{
    use SoftDeletes, HasTranslation, HasMedia;

    protected $table = 'containers';
    protected $guarded = ['id'];

    public function structure()
    {
        return $this->belongsTo(Structure::class);
    }

    public function translations()
    {
        return $this->hasMany(ContainerTranslation::class);
    }

    public function customPages(string $key = null)
    {
        $pages = $this->belongsToMany(Page::class, 'container_pages');

        if($key) {
            $pages = $pages->wherePivot('key', $key);
        }

        return $pages;
    }
}
