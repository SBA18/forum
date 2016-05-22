<?php

namespace Forum\Models;

use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use EntrustUserTrait;
    
    protected $fillable = [
        'username',
        'email',
        'first_name',
        'last_name',
        'location',
        'website',
        'about',
        'image_uuid',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function getNameOrUsername()
    {
        if ($this->first_name && $this->last_name) {
            return $this->first_name . ' ' . $this->last_name;
        } else if ($this->first_name && !$this->last_name) {
            return $this->first_name;
        } else {
            return $this->username;
        }
    }

    public function getFullNameOrUsername()
    {
        if ($this->first_name && $this->last_name) {
            return $this->first_name . ' ' . $this->last_name;
        } else {
            return $this->username;
        }
    }

    public function getFullName()
    {
        if ($this->first_name && $this->last_name) {
            return $this->first_name . ' ' . $this->last_name;
        }
    }

    public function avatarUrl(array $options = [])
    {
        $size = array_get($options, 'size', 45);

        if ($this->image_uuid) {
            return 'https://ucarecdn.com/' . $this->image_uuid . '/-/scale_crop/1024x1024/center/-/quality/lighter/-/progressive/yes/-/resize/' . $size . '/';
        }

        return 'https://www.gravatar.com/avatar/' . md5(strtolower($this->email)) . '?s=' . $size . '&d=mm';
    }

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }
}
