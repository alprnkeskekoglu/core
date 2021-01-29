<?php

namespace Dawnstar\Models;

class ContainerDetailExtra extends BaseModel
{
    protected $table = 'container_detail_extras';
    protected $dates = ['created_at', 'updated_at'];

    protected $guarded = ['id'];

    public function detail()
    {
        return $this->belongsTo(ContainerDetail::class);
    }
}
