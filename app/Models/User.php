<?php

namespace App\Models;

use App\Traits\SearchTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use SearchTrait;

    protected $table = 'tbl_user';

    protected $primaryKey = 'id';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'avatar',
        'code',
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'code',
        'email_verified_at'
    ];

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $attributes['last_name'] . $attributes['first_name']
        );
    }

    public function review()
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    public function news()
    {
        return $this->hasMany(News::class, 'user_id');
    }

    public function comment()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function like_dislike()
    {
        return $this->hasMany(LikeDislike::class, 'user_id');
    }

    protected $searchable = [
        'first_name',
        'last_name',
        'email',
        'phone'
    ];
}
