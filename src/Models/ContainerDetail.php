<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContainerDetail extends Model
{
    use SoftDeletes;
    protected $table = 'container_details';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['id'];

    public function container()
    {
        return $this->belongsTo(Container::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
