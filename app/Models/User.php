<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;

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
        'password'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $with = ['role'];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'admin_id');
    }

    public function news()
    {
        return $this->hasMany(News::class, 'admin_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'user_id');
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    protected function getFullNameAttribute()
    {
        return $this->last_name . ' ' . $this->first_name;
    }

    public function getIsAdminAttribute() {
        return $this->role->name !== 'User' ? true : false;
    }

    public function getAvatarUrl()
    {
        return asset($this->avatar ?
            'images/avatars/' . $this->avatar
            : ($this->isAdmin ?
                'images/avatars/no-avatar.jpg'
                : 'images/avatars/no-avatar-admin.png'));
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
