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
        return $this->belongsTo(Role::class, 'role_id')->withDefault(function (Role $role) {
            $role->name = 'Deleted';
        });
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
            get: fn () => $this->role->name && $this->role->name !== 'User'
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

    // Search
    public function scopeSearch($query, $term)
    {
        return $query->when($term, function ($query) use ($term) {
            $term = '%' . trim($term) . '%';
            return $query->whereRaw("TRIM(CONCAT(last_name, ' ', first_name)) like '{$term}'")
                ->orWhere('email', 'LIKE', $term)
                ->orWhere('phone', 'LIKE', $term);
        });
    }

    public function scopeGetAdmin($query)
    {
        return $query->whereDoesntHave('role', function ($query) {
            $query->select('name')->where('name', 'User');
        });
    }

    // Sắp xếp
    public function scopeSort($query, $sortBy, $sortDirection)
    {
        switch ($sortBy) {
            case 'full_name':
                $users = $sortDirection === 'asc' ? $query->get()->sortBy('full_name') : $query->get()->sortByDesc('full_name');
                $ids = $users->pluck('id')->toArray();
                $sortedIds = implode(',', $ids);
                return $query->orderByRaw("FIELD(id, $sortedIds)");
            case 'role':
                return $query->select('users.*', 'roles.name')
                ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
                    ->orderBy('roles.name', $sortDirection);
            default:
                return $query->orderBy($sortBy, $sortDirection);
        }
    }

    // Lọc
    public function scopeFilter($query, $role, $status, $dateFrom, $dateTo)
    {
        return $query->when($role, function ($query) use ($role) {
            return $query->where('role_id', $role);
        })->when($status != '', function ($query) use ($status) {
            return $query->where('is_active', $status);
        })->whereDate('users.created_at', '>=', $dateFrom)->whereDate('users.created_at', '<=', $dateTo);
    }
}
