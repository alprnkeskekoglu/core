<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Url extends Model
{
    use SoftDeletes;
    protected $table = 'urls';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['id'];

    public function model()
    {
        return $this->morphTo(__FUNCTION__, 'model_class', 'model_id');
    }
}
