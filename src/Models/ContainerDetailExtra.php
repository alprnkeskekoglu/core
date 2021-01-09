<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;

class ContainerDetailExtra extends Model
{
    protected $table = 'container_detail_extras';
    protected $dates = ['created_at', 'updated_at'];

    protected $guarded = ['id'];

    public function detail()
    {
        return $this->belongsTo(ContainerDetail::class);
    }
}
