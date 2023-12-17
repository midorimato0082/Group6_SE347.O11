<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';

    protected $primaryKey = 'id';

    protected $fillable = [
        'content',
        'user_id',
        'post_id',
        'reply_id'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected $withCount = ['likes'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'comment_likes', 'comment_id', 'user_id');
    }

    public function replies()
    {
        return $this->hasMany(Comment::class, 'reply_id');
    }

    protected function createdTime(): Attribute
    {
        return new Attribute(
            get: fn () => $this->created_at->format('d-m-Y H:i:s')
        );
    }

    protected function updatedTime(): Attribute
    {
        return new Attribute(
            get: fn () => $this->updated_at->format('d-m-Y H:i:s')
        );
    }

    public function isReply()
    {
        return is_null($this->reply_id);
    }

    // public function scopeSearch($query, $term)
    // {
    //     return $query->when(!empty($term), function ($query) use ($term) {
    //         $term = '%' . trim($term) . '%';
    //         return $query->where('content', 'LIKE', $term)
    //             ->orWhere('created_at', 'LIKE', $term)
    //             ->orWhereHas('user', function ($query) use ($term) {
    //                 $query->where('first_name', 'LIKE', $term)
    //                     ->orWhere('last_name', 'LIKE', $term)
    //                     ->orWhere('email', 'LIKE', $term);
    //             })
    //             ->orWhereHas('review', function ($query) use ($term) {
    //                 $query->where('title', 'LIKE', $term);
    //             });
    //     });
    // }
}
