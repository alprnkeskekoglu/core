<?php

namespace Dawnstar\Models;

use Dawnstar\FileManager\Models\Media;
use Dawnstar\Traits\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends BaseModel
{
    protected $connection = 'locale_sqlite';
    protected $table = 'countries';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function cities()
    {
        return $this->hasMany(City::class);
    }

}
