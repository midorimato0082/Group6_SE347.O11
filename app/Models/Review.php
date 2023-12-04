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
        'tags',
        'category_id',
        'location_id',
        'admin_id',
        'is_active'
    ];

    // Kiến thức Eloquent: Relationships phần Eager Loading   
    protected $with = ['images:name,review_id', 'category:id,name', 'location:id,name,region_id', 'admin:id,first_name,last_name,email'];

    // Kiến thức Eloquent: Relationships
    public function images()
    {
        return $this->hasMany(ReviewImages::class, 'review_id');
    }

    public function category()
    {
        // Dùng default để khi mã id category đó đã bị xóa thì sẽ trả về giá trị cột name là trống
        return $this->belongsTo(Category::class, 'category_id')->withDefault(function (Category $category) {
            $category->name = null;
        });
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id')->withDefault(function (Location $location) {
            $location->name = null;
        });
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id')->withDefault(function (User $user) {
            $user->first_name = null;
            $user->last_name = null;
            $user->email = null;
        });
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'review_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'review_id');
    }

    // Hàm lấy url của hình đầu tiên, viết hàm này để set thuộc tính src của tag image trong view ngắn gọn hơn
    public function getFirstImageUrl()
    {
        return $this->images->isNotEmpty() ? $this->images->first()->url : asset('images/others/no-image.jpg');
    }

    // Hàm lấy url của tất cả các hình của bài viết
    public function getImagesUrl()
    {
        if ($this->images->isEmpty())
            return [asset('images/others/no-image.jpg')];

        foreach ($this->images as $image)
            $imagesUrl[] = $image->url;
        return $imagesUrl;
    }

    // Hàm lấy các review có region name là $term. Ví dụ lấy các bài viết thuộc miền bắc.
    public function scopeWhereRegion($query, $term)
    {
        return $query->whereRelation('location.region', 'name', $term);
    }

    // Hàm lấy giá trị cho cột comment_count (số lượt bình luận của review), like_count, dislike_count. Database mới đã bỏ các cột này đi. Bây giờ hệ thống sẽ tự generate nó.
    public function scopeCount($query)
    {
        return $query->withCount([
            'comments', 'likes as like_count' => function ($query) {
                $query->where('is_like', 1);
            }, 'likes as dislike_count' => function ($query) {
                $query->where('is_like', 0);
            }
        ]);
    }

    public function scopeSearch($query, $term)
    {
        return $query->when($term, function ($query) use ($term) {
            $term = '%' . trim($term) . '%';
            return $query->where('title', 'LIKE', $term)
                ->orWhere('tags', 'LIKE', $term)
                ->orWhere('reviews.created_at', 'LIKE', $term)
                ->orWhere('reviews.updated_at', 'LIKE', $term);
        });
    }

    public function scopeFilter($query, $category, $region, $location, $admin, $status, $dateFrom, $dateTo)
    {
        return $query->when($category, function ($query) use ($category) {
            return $query->where('category_id', $category);
        })->when($region, function ($query) use ($region) {
            return $query->whereRegion($region);
        })->when($location, function ($query) use ($location) {
            return $query->where('location_id', $location);
        })->when($admin, function ($query) use ($admin) {
            return $query->where('admin_id', $admin);
        })->when($status != '', function ($query) use ($status) {
            return $query->where('is_active', $status);
        })->whereDate('reviews.created_at', '>=', $dateFrom)->whereDate('reviews.created_at', '<=', $dateTo);
    }

    public function scopeSort($query, $sortBy, $sortDirection)
    {
        switch ($sortBy) {
            case 'category':
                return $query->leftJoin('categories', 'reviews.category_id', '=', 'categories.id')->orderBy('categories.name', $sortDirection);
            case 'region':
                return $query->leftJoin('locations', 'reviews.location_id', '=', 'locations.id')->leftJoin('regions', 'locations.region_id', '=', 'regions.id')->orderBy('regions.name', $sortDirection);
            case 'location':
                return $query->leftJoin('locations', 'reviews.location_id', '=', 'locations.id')->orderBy('locations.name', $sortDirection);
            case 'admin':
                return $query->leftJoin('users', 'reviews.admin_id', '=', 'users.id')->orderBy('users.first_name', $sortDirection);
            default:
                return $query->orderBy($sortBy, $sortDirection);
        }
    }
}
