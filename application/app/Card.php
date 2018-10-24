<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = 'cards';

    protected $fillable = [
        'user_id', 'lastfour', 'card_type', 'card_expires'
    ];
}
