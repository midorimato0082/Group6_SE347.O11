<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likes';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'review_id',
        'news_id',
        'is_like',       // like: 1; dislike: 0
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }

    public function review()
    {
        return $this->belongsTo(Review::class, 'review_id'); 
    }

    public function news()
    {
        return $this->belongsTo(News::class, 'news_id'); 
    }
}
