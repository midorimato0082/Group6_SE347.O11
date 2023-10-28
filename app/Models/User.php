<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'avatar',
        'code',
        'email_verified_at',
        'is_admin'
    ];

    protected $hidden = [
        'password',
        'code',
        'email_verified_at'
    ];

    protected function getFullNameAttribute()
    {
        return $this->last_name . ' ' . $this->first_name;
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    public function news()
    {
        return $this->hasMany(News::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'user_id');
    }

    public function scopeSearch($query, $term)
    {
        $term = '%' . $term . '%';
        $query->where(function ($query) use ($term) {
            $query->whereRaw("TRIM(CONCAT(last_name, ' ', first_name)) like '{$term}'")
                ->orWhere('email', 'LIKE', $term)
                ->orWhere('phone', 'LIKE', $term);
        });
    }
}
