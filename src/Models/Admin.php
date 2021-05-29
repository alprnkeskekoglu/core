<?php

namespace Dawnstar\Models;

use Dawnstar\Traits\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use SoftDeletes, HasMedia, HasRoles;

    protected $table = 'admins';

    protected $guarded = ['id'];

    protected $hidden = [
        'password'
    ];

    public function guardName()
    {
        return 'admin';
    }

    public function __get($key)
    {
        $attribute = $this->getAttribute($key);

        if ($attribute) {
            return $attribute;
        }

        if(\Str::startsWith($key, 'mf_')) {
            $mediaKey = mb_substr($key, 3);
            $medias = $this->medias();
            if($mediaKey) {
                $medias->wherePivot('media_key', $mediaKey);
            }
            return $medias->first();
        } elseif(\Str::startsWith($key, 'mc_')) {
            $mediaKey = mb_substr($key, 3);
            $medias = $this->medias();
            if($mediaKey) {
                $medias->wherePivot('media_key', $mediaKey);
            }
            return $medias->get();
        }

        return $attribute;
    }
}
