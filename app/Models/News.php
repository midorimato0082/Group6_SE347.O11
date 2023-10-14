<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'tbl_news';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'slug',
        'desc',
        'content',
        'images',
        'tags',
        'admin_id',
        'status'
    ];

    public function admin() {
        return $this->belongsTo(User::class, 'admin_id'); 
    }

    public function comment() {
        return $this->hasMany(Comment::class, 'news_id');
    }  

    public function like_dislike()
    {
        return $this->hasMany(LikeDislike::class, 'news_id');
    }
}
