<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable, HasFactory;

    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $fillable = [
        'last_name',
        'first_name',
        'email',
        'password',
        'phone',
        'avatar'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean'
    ];

    protected $with = ['role'];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'admin_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function postlikes()
    {
        return $this->belongsToMany(Post::class, 'post_likes', 'user_id', 'post_id')->withPivot('is_like')->using(PostLike::class);
    }

    public function commentlikes()
    {
        return $this->belongsToMany(Comment::class, 'comment_likes', 'user_id', 'comment_id')->using(CommentLike::class);
    }

    public function places()
    {
        return $this->belongsToMany(Place::class, 'ratings', 'user_id', 'place_id')->withPivot('star')->using(Rating::class);
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    protected function fullName(): Attribute
    {
        return new Attribute(
            get: fn () => $this->last_name . ' ' . $this->first_name
        );
    }

    protected function isAdmin(): Attribute
    {
        return new Attribute(
            get: fn () => $this->role->name !== 'User'
        );
    }

    protected function avatarUrl(): Attribute
    {
        return new Attribute(
            get: fn () => asset($this->avatar ?
                'images/avatars/' . $this->avatar :
                'images/others/' . ($this->is_admin ? 'no-avatar-admin.png' : 'no-avatar.jpg'))
        );
    }

    public function scopeSearch($query, $term)
    {
        $term = '%' . $term . '%';

        $query->whereRaw("TRIM(CONCAT(last_name, ' ', first_name)) like '{$term}'")
            ->orWhere('email', 'LIKE', $term)
            ->orWhere('phone', 'LIKE', $term);
    }

    public function scopeGetAdmin($query)
    {
        return $query->whereDoesntHave('role', function ($query) {
            $query->select('name')->where('name', 'User');
        });
    }
}
