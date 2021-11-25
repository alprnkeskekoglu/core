<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;

class AdminAction extends Model
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

    public function getTypeTranslationAttribute()
    {
        return __('Dawnstar::admin_action.types.' . $this->type);
    }

    public function getTypeColorAttribute()
    {
        switch ($this->type) {
            case 'store':
                return 'success';
            case 'update':
                return 'primary';
            case 'destroy':
                return 'danger';
        }
    }
}
