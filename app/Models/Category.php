<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'slug',
        'is_place',
        'is_active'
    ];

    protected $casts = [
        'is_place' => 'boolean',
        'is_active' => 'boolean'
    ];

    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }

    public function places()
    {
        return $this->hasMany(Place::class, 'category_id');
    }
}
