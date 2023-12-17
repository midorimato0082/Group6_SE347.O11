<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    protected $table = 'post_images';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'post_id',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    protected function url(): Attribute
    {
        return new Attribute(
            get: fn () => asset('images/posts/' . $this->name)
        );
    }
}