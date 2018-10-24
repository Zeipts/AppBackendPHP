<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'email', 'password', 'cid'
    ];

    protected $hidden = [
        'password', 'remember_token', 'cid'
    ];

    public function cards()
    {
        return $this->hasMany('App\Card')->whereNotNull('lastfour');
    }

    public function sessions()
    {
        return $this->hasMany('App\Session');
    }

    public function session()
    {
        return $this->hasMany('App\Session')->where('expired', false)->latest();
    }
}
