<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'slug',
        'desc',
        'content',
        'images',
        'tags',
        'category_id',
        'location_id',
        'admin_id',
        'is_active'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'review_id'); 
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'review_id');
    }
}
