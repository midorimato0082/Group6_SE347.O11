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

    public function scopeSearch($query, $term)
    {
        return $query->when($term, function ($query) use ($term) {
            $term = '%' . trim($term) . '%';
            return $query->where('categories.name', 'LIKE', $term)
                ->orWhere('categories.created_at', 'LIKE', $term);
        });
    }

    public function scopeFilter($query, $status, $dateFrom, $dateTo)
    {
        return $query->when($status != '', function ($query) use ($status) {
            return $query->where('categories.is_active', $status);
        })->whereDate('categories.created_at', '>=', $dateFrom)->whereDate('categories.created_at', '<=', $dateTo);
    }
}
