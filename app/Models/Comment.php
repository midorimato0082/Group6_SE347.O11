<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'tbl_comment';

    protected $primaryKey = 'id';

    protected $fillable = [
        'content',
        'user_id',
        'review_id',
        'news_id',
        'status',
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
