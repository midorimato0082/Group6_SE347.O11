<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Review extends Pivot
{
    protected $table = 'reviews';

    protected $fillable = [
        'post_id',
        'place_id'
    ];
}
