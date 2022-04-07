<?php

namespace Dawnstar\Core\Models;

use Illuminate\Database\Eloquent\Model;

class FormMessageMedia extends Model
{
    protected $table = 'form_message_medias';
    protected $fillable = ['form_message_id', 'media_id'];
    public $timestamps = false;
}
