<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'slug',
        'desc',
        'content',
        'images',
        'tags',
        'admin_id',
        'is_active'
    ];

    public function admin() {
        return $this->belongsTo(User::class, 'admin_id'); 
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'news_id');
    }  

    public function likes()
    {
        return $this->hasMany(Like::class, 'news_id');
    }
}
