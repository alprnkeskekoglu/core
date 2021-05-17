<?php

namespace Dawnstar\Models;

class City extends BaseModel
{
    protected $connection = 'locale_sqlite';
    protected $table = 'cities';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

}
