<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Session extends Model
{
    protected $table = 'sessions';

    protected $fillable = [
        'user_id', 'token', 'created_at', 'expired'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
