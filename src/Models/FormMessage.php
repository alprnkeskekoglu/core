<?php

namespace Dawnstar\Core\Models;

use Dawnstar\MediaManager\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormMessage extends BaseModel
{
    use SoftDeletes;

    protected $table = 'form_messages';
    protected $guarded = ['id'];
    protected $casts = ['data' => 'array'];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function medias()
    {
        return $this->belongsToMany(Media::class, 'form_message_medias');
    }
}
