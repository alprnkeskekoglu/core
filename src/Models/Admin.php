<?php

namespace Dawnstar\Models;

use Dawnstar\Traits\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use SoftDeletes;
    use HasMedia;

    protected $table = 'admins';

    protected $guarded = ['id'];

    protected $hidden = [
        'password'
    ];

    public function __get($key)
    {
        $attribute = $this->getAttribute($key);

        if ($attribute) {
            return $attribute;
        }

        if(\Str::startsWith($key, 'mf_')) {
            $mediaKey = mb_substr($key, 3);
            return $this->medias()->wherePivot('media_key', $mediaKey)->first();
        } elseif(\Str::startsWith($key, 'mc_')) {
            $mediaKey = mb_substr($key, 3);
            return $this->medias()->wherePivot('media_key', $mediaKey)->get();
        }

        return $attribute;
    }
}
