<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class FormBuilder extends BaseModel
{
    protected $table = 'form_builders';
    protected $guarded = ['id'];
    protected $casts = [
        'data' => 'array'
    ];

    public function container()
    {
        return $this->belongsTo(Container::class);
    }

    public function getDiscountAmountAttribute()
    {
        return $this->discount->sum('amount');
    }
}
