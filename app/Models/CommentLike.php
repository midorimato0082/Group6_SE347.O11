<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CommentLike extends Pivot
{
    protected $table = 'comment_likes';

    protected $fillable = [
        'user_id',
        'comment_id'
    ];
}