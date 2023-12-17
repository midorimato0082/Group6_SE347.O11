<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Rating extends Pivot
{
    protected $table = 'ratings';

    protected $fillable = [
        'user_id',
        'place_id',
        'star'
    ];
}
