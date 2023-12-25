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

    protected $with = ['post', 'user', 'replies'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault(function (User $user) {
            $user->first_name = 'Deleted';
        });
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id')->withDefault(function (Post $post) {
            $post->title = 'Deleted';
        });
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

    protected function repliesCount(): Attribute
    {
        return new Attribute(
            get: fn () => $this->replies->count()
        );
    }

    // Search
    public function scopeSearch($query, $term)
    {
        return $query->when($term, function ($query) use ($term) {
            $term = '%' . trim($term) . '%';
            return $query->where('comments.content', 'LIKE', $term)
                ->orWhereHas('user', function ($query) use ($term) {
                    $query->whereRaw("TRIM(CONCAT(last_name, ' ', first_name)) like '{$term}'");
                })
                ->orWhereRelation('user', 'email', 'LIKE', $term)
                ->orWhere('comments.created_at', 'LIKE', $term)
                ->orWhereRelation('post', 'title', 'LIKE', $term);
        });
    }

    public function scopeFilter($query, $status, $dateFrom, $dateTo)
    {
        return $query->when($status != '', function ($query) use ($status) {
            return $query->where('comments.is_active', $status);
        })->whereDate('comments.created_at', '>=', $dateFrom)->whereDate('comments.created_at', '<=', $dateTo);
    }

    // Sắp xếp
    public function scopeSort($query, $sortBy, $sortDirection)
    {
        switch ($sortBy) {
            case 'user':
                return $query
                    ->select('comments.*', 'users.first_name')
                    ->leftJoin('users', 'comments.user_id', '=', 'users.id')
                    ->orderBy('users.first_name', $sortDirection);
            case 'title':
                return $query
                    ->select('comments.*', 'posts.title')
                    ->leftJoin('posts', 'comments.post_id', '=', 'posts.id')
                    ->orderBy('posts.title', $sortDirection);
            case 'replies':
                $comments = $sortDirection === 'asc' ? $query->get()->sortBy('replies_count ') : $query->get()->sortByDesc('replies_count ');
                $ids = $comments->pluck('id')->toArray();
                $sortedIds = implode(',', $ids);
                return $query->orderByRaw("FIELD(id, $sortedIds)");
            default:
                return $query->orderBy($sortBy, $sortDirection);
        }
    }
}
