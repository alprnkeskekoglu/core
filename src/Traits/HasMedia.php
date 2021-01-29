<?php

namespace Dawnstar\Traits;

use Dawnstar\FileManager\Models\Media;
use Dawnstar\Models\Language;

trait HasMedia{

    public function medias()
    {
        return $this->morphToMany(Media::class, 'model', 'model_medias');
    }
}
