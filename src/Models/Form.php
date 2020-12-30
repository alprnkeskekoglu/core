<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Form extends Model
{
    use SoftDeletes;
    protected $table = 'forms';
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts = [
        'receivers' => 'array'
    ];
    protected $guarded = ['id'];

    public function getStatusTextAttribute()
    {
        switch ($this->status) {
            case 1:
                return __('DawnstarLang::general.status_title.active');
            case 2:
                return __('DawnstarLang::general.status_title.draft');
            case 3:
                return __('DawnstarLang::general.status_title.passive');
        }
    }
}
