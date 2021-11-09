<?php

namespace Dawnstar\Models;

use Dawnstar\Traits\HasTranslation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Container extends BaseModel
{
    use SoftDeletes, HasTranslation;

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
}
