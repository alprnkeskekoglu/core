<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Form extends BaseModel
{
    use SoftDeletes;
    protected $table = 'forms';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [
        'receivers' => 'array'
    ];
    protected $guarded = ['id'];

    public function results()
    {
        return $this->hasMany(FormResult::class);
    }

    public function getReadResultCountAttribute()
    {
        return $this->results()->where('read', 1)->count();
    }

    public function getUnreadResultCountAttribute()
    {
        return $this->results()->where('read', 2)->count();
    }
}
