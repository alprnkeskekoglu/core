<?php

namespace Dawnstar\Core\Models;

use Dawnstar\MediaManager\Traits\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use SoftDeletes, HasMedia, HasRoles;

    protected $table = 'admins';
    protected $guarded = ['id'];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public static function boot()
    {
        static::created(function ($model) {
            adminAction($model, 'store');
            Cache::flush();
        });

        static::updated(function ($model) {
            adminAction($model, 'update');
            Cache::flush();
        });

        static::deleted(function ($model) {
            adminAction($model, 'destroy');
            Cache::flush();
        });

        parent::boot();
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function actions()
    {
        return $this->hasMany(AdminAction::class);
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function __get($key)
    {
        $attribute = $this->getAttribute($key);

        if ($attribute) {
            return $attribute;
        }

        if (method_exists($this, 'extras')) {
            if(\Str::startsWith($key, 'mf_')) {
                $key = mb_substr($key, 3);
                $medias = $this->medias();
                if($key) {
                    $medias->wherePivot('key', $key);
                }
                return $medias->orderBy('model_medias.order')->first();
            } elseif(\Str::startsWith($key, 'mc_')) {
                $key = mb_substr($key, 3);
                $medias = $this->medias();
                if($key) {
                    $medias->wherePivot('key', $key);
                }
                return $medias->orderBy('model_medias.order')->get();
            }
        }

        return $attribute;
    }
}
