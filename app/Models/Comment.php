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
        'is_active'
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

    public function getTitleAttribute()
    {
        // return $this->review_id ? Review::find($this->review_id)->title : News::find($this->news_id)->title;
        return $this->review_id ? $this->review->title : $this->news->title;
    }

    public function scopeSearch($query, $term)
    {
        $term = '%' . $term . '%';
        return $query->where(function ($query) use ($term) {
            return $query->where('content', 'LIKE', $term)
                ->orWhere('created_at', 'LIKE', $term)
                ->orWhereHas('user', function ($query) use ($term) {
                    return $query->where('first_name', 'LIKE', $term)
                        ->orWhere('last_name', 'LIKE', $term)
                        ->orWhere('email', 'LIKE', $term);
                })
                ->orWhereHas('review', function ($query) use ($term) {
                    return $query->where('title', 'LIKE', $term);
                })
                ->orWhereHas('news', function ($query) use ($term) {
                    return $query->where('title', 'LIKE', $term);
                });
        });
    }
}
