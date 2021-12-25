<?php

namespace Dawnstar\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Form extends BaseModel
{
    use SoftDeletes;

    protected $table = 'forms';
    protected $guarded = ['id'];
    protected $casts = ['receiver_emails' => 'array'];

    public function messages()
    {
        return $this->hasMany(FormMessage::class);
    }

    public function unreadMessages()
    {
        return $this->hasMany(FormMessage::class)->where('read', 0);
    }
}
