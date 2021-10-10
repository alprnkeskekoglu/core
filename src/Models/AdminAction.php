<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;

class AdminAction extends BaseModel
{
    protected $table = 'admin_actions';
    protected $guarded = ['id'];

    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function model()
    {
        return $this->morphTo('model');
    }
}
