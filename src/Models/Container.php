<?php

namespace Dawnstar\Models;

use Dawnstar\Traits\HasDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Container extends Model
{
    use SoftDeletes;
    use HasDetail;
    
    protected $table = 'containers';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $guarded = ['id'];


    public function details()
    {
        return $this->hasMany(ContainerDetail::class);
    }
}
