<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PostLike extends Pivot
{
    protected $table = 'post_likes';

    protected $fillable = [
        'user_id',
        'post_id',
        'is_like'
    ];

    protected $casts = [
        'is_like' => 'boolean'
    ];
}
