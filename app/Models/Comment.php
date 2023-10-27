<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    protected $primaryKey = 'id';

    protected $fillable = [
        'content',
        'user_id',
        'review_id',
        'news_id',
        'is_active',
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

    protected $searchable = [
        'content',
    ];
}
