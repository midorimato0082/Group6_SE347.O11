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
        'is_active'
    ];

    // protected $with = ['category:id,name', 'location', 'admin'];    // Kiến thức Eloquent: Relationships phần Eager Loading
    protected $with = ['category:name', 'location', 'admin'];

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
        return $this->belongsTo(User::class, 'admin_id')->withDefault(function (User $user) {
            $user->first_name = '';
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
        return asset('images/reviews/' . ($this->images ?  explode(' | ', $this->images)[0] : 'no-image.jpg'));
    }

    // Hàm lấy url của tất cả các hình của bài viết
    public function getImagesUrl()
    {
        if (empty($this->images))
            return [asset('images/reviews/no-image.jpg')];

        foreach (explode(' | ', $this->images) as $image) {
            $imagesUrl[] = asset('images/reviews/' . $image);
        }
        return $imagesUrl;
    }

    // Kiến thức Mutate Eloquent Model Attributes phần Using an Accessor. Hàm lấy name của region_id tương ứng.
    public function getRegionAttribute()
    {
        return Region::find($this->location->region_id)->name;
    }

    // Hàm lấy các review có region name là $term. Ví dụ lấy các bài viết thuộc miền bắc.
    public function scopeGetRegion($query, $term)
    {
        return $query->whereHas('location.region', function ($query) use ($term) {
            return $query->where('name', $term);
        });
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
        return $query->when(!empty($term), function ($query) use ($term) {
            $term = '%' . trim($term) . '%';
            return $query->where('title', 'LIKE', $term)
                ->orWhere('tags', 'LIKE', $term)
                ->orWhere('reviews.created_at', 'LIKE', $term)
                ->orWhere('reviews.updated_at', 'LIKE', $term);
        });
    }

    public function scopeFilter($query, $category, $region, $location, $admin, $status, $dateFrom, $dateTo)
    {
        return $query->when(!empty($category), function ($query) use ($category) {
            return $query->where('category_id', $category);
        })->when(!empty($region), function ($query) use ($region) {
            return $query->getRegion($region);
        })->when(!empty($location), function ($query) use ($location) {
            return $query->where('location_id', $location);
        })->when(!empty($admin), function ($query) use ($admin) {
            return $query->where('admin_id', $admin);
        })->when($status !== "", function ($query) use ($status) {
            return $query->where('is_active', $status);
        })->whereDate('reviews.created_at', '>=', $dateFrom)->whereDate('reviews.created_at', '<=', $dateTo);
    }

    public function scopeSort($query, $sortBy, $sortDirection)
    {
        switch ($sortBy) {
            case 'category':
                return $query->join('categories', 'reviews.category_id', '=', 'categories.id')->orderBy('categories.name', $sortDirection);
            case 'region':
                return $query->join('locations', 'reviews.location_id', '=', 'locations.id')->join('regions', 'locations.region_id', '=', 'regions.id')->orderBy('regions.name', $sortDirection);
            case 'location':
                return $query->join('locations', 'reviews.location_id', '=', 'locations.id')->orderBy('locations.name', $sortDirection);
            case 'admin':
                return $query->join('users', 'reviews.admin_id', '=', 'users.id')->orderBy('users.first_name', $sortDirection);
            default:
                return $query->orderBy($sortBy, $sortDirection);
        }
    }
}
