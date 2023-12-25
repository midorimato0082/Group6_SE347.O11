<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'slug',
        'desc',
        'content',
        'tags',
        'category_id',
        'admin_id',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected $with = ['places', 'images:name,post_id', 'category:id,name,slug', 'admin:id,first_name,last_name,email'];

    public function images()
    {
        return $this->hasMany(PostImage::class, 'post_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->withDefault(function (Category $category) {
            $category->name = 'Deleted';
            $category->slug = 'Deleted';
        });
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id')->withDefault(function (User $user) {
            $user->first_name = 'Deleted';
            $user->email = 'Deleted';
        });
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'post_likes', 'post_id', 'user_id')->withPivot('is_like')->using(PostLike::class);
    }

    public function places()
    {
        return $this->belongsToMany(Place::class, 'reviews', 'post_id', 'place_id')->using(Review::class);
    }

    // Lấy url của hình đầu tiên, viết hàm này để set thuộc tính src của tag image trong view ngắn gọn hơn
    protected function firstImage(): Attribute
    {
        return new Attribute(
            get: fn () => $this->images->isNotEmpty() ? $this->images->first()->url : asset('images/others/no-image.jpg')
        );
    }

    // Lấy url của tất cả các hình của bài viết
    public function getImagesUrl()
    {
        if ($this->images->isEmpty())
            return [asset('images/others/no-image.jpg')];

        foreach ($this->images as $image)
            $imagesUrl[] = $image->url;
        return $imagesUrl;
    }

    // Định dạng hiển thị thời gian
    protected function createdTime(): Attribute
    {
        return new Attribute(
            get: fn () => $this->created_at->format('d-m-Y H:i:s')
        );
    }

    // Định dạng hiển thị thời gian
    protected function updatedTime(): Attribute
    {
        return new Attribute(
            get: fn () => $this->updated_at->format('d-m-Y H:i:s')
        );
    }

    public function getTags()
    {
        if ($this->tags) {
            foreach (explode(',', $this->tags) as $tag)
                $tags[] = $tag;
            return $tags;
        }
        return [];
    }

    // Lấy bài viết trước
    protected function previous(): Attribute
    {
        return new Attribute(
            get: fn () => $this->where('id', '<', $this->id)->orderBy('id', 'desc')->first(['title', 'slug']) ?? $this->orderBy('id', 'desc')->first(['title', 'slug'])
        );
    }

    // Lấy bài viết tiếp theo
    protected function next(): Attribute
    {
        return new Attribute(
            get: fn () => $this->where('id', '>', $this->id)->orderBy('id', 'asc')->first(['title', 'slug']) ?? $this->orderBy('id', 'asc')->first(['title', 'slug'])
        );
    }

    // Place có rating cao nhất trong số các place được đề cập đến trong post
    protected function bestStarPlace(): Attribute
    {
        return new Attribute(
            get: fn () => $this->places->where('star', $this->places->max('star'))->first()
        );
    }

    // Tên các place được bài viết review
    protected function getPlacesNameAttribute()
    {
        $places = array();
        foreach ($this->places as $place)
            $places[] = $place->name;

        return implode(', ', $places);
    }

    // Lấy giá trị cho cột comment_count (số lượt bình luận của review), like_count, dislike_count.
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

    // Lấy các review có region name là $term. Ví dụ lấy các bài viết thuộc miền bắc.
    public function scopeWhereRegion($query, $term)
    {
        return $query->whereRelation('places.district.province.region', 'name', $term);
    }

    // Lấy range giá tiền từ các place được bài viết đề cập
    public function scopeRangePrice($query)
    {
        return $query->withMin('places as min_price', 'min_price')->withMax('places as max_price', 'max_price');
    }

    // Định dạng hiển thị số tiền
    public function formatRangePrice($minPrice, $maxPrice)
    {
        return number_format($minPrice, 0, '.', ',') . '<sup>đ</sup> - ' . number_format($maxPrice, 0, '.', ',') . '<sup>đ</sup>';
    }

    // Sắp xếp
    public function scopeSort($query, $sortBy, $sortDirection)
    {
        switch ($sortBy) {
            case 'star':
                $posts = $sortDirection === 'asc' ? $query->get()->sortBy('best_star_place.star') : $query->get()->sortByDesc('best_star_place.star');
                $ids = $posts->pluck('id')->toArray();
                $sortedIds = implode(',', $ids);
                return $query->orderByRaw("FIELD(id, $sortedIds)");
            case 'category':
                return $query
                ->select('posts.*', 'categories.name')
                ->leftJoin('categories', 'posts.category_id', '=', 'categories.id')
                ->orderBy('categories.name', $sortDirection);
            case 'places':
                $posts = $sortDirection === 'asc' ? $query->get()->sortBy('places_name') : $query->get()->sortByDesc('places_name');
                $ids = $posts->pluck('id')->toArray();
                $sortedIds = implode(',', $ids);
                return $query->orderByRaw("FIELD(id, $sortedIds)");
            case 'admin':
                return $query
                ->select('posts.*', 'users.first_name')
                ->leftJoin('users', 'posts.admin_id', '=', 'users.id')
                ->orderBy('users.first_name', $sortDirection);
            default:
                return $query->orderBy($sortBy, $sortDirection);
        }
    }

    //Show Post trên menu page
    public function scopeShow($query, $category, $region)
    {
        return $query->when($category, function ($query) use ($category) {
            return $query->where('category_id', $category);
        })->when($region, function ($query) use ($region) {
            return $query->whereRegion($region);
        });
    }

    // Lọc tìm kiếm trên page
    public function scopeFilter($query, $categories, $regions, $provinces, $districts, $minPrice, $maxPrice, $star)
    {
        return $query->when($categories, function ($query) use ($categories) {
            return $query->whereHas('category', fn ($query) => $query->whereIn('name', $categories));
        })->when($regions, function ($query) use ($regions) {
            return $query->whereHas('places.district.province.region', fn ($query) => $query->whereIn('name', $regions));
        })->when($provinces, function ($query) use ($provinces) {
            return $query->whereHas('places.district.province', fn ($query) => $query->whereIn('name', $provinces));
        })->when($districts, function ($query) use ($districts) {
            return $query->whereHas('places.district', fn ($query) => $query->whereIn('name', $districts));
        })->when($minPrice, function ($query) use ($minPrice) {
            $ids = $query->get()->where('min_price', '>=', $minPrice)->pluck('id');
            return $query->when($ids, fn ($query) => $query->whereIn('id', $ids));
        })->when($maxPrice, function ($query) use ($maxPrice) {
            $ids = $query->get()->where('min_price', '<=', $maxPrice)->pluck('id');
            return $query->when($ids, fn ($query) => $query->whereIn('id', $ids));
        })->when($star, function ($query) use ($star) {
            $ids = $query->get()->where('best_star_place.star', '>=', $star)->pluck('id');
            return $query->when($ids, fn ($query) => $query->whereIn('id', $ids));
        });
    }

    public function scopeSearchPage($query, $term)
    {
        return $query->when($term, function ($query) use ($term) {
            $term = '%' . trim($term) . '%';
            return $query->where('title', 'LIKE', $term)
                ->orWhere('tags', 'LIKE', $term)
                ->orWhereRelation('places', 'name', 'LIKE', $term);
        });
    }

    public function scopeSearch($query, $term)
    {
        return $query->when($term, function ($query) use ($term) {
            $term = '%' . trim($term) . '%';
            return $query->where('title', 'LIKE', $term)
                ->orWhere('tags', 'LIKE', $term)
                ->orWhereRelation('admin', 'email', 'LIKE', $term)
                ->orWhereHas('admin', function ($query) use ($term) {
                    $query->whereRaw("TRIM(CONCAT(last_name, ' ', first_name)) like '{$term}'");
                })
                ->orWhereRelation('places', 'name', 'LIKE', $term)
                ->orWhere('posts.created_at', 'LIKE', $term)
                ->orWhere('posts.updated_at', 'LIKE', $term);
        });
    }

    public function scopeFilter2($query, $category, $region, $admin, $status, $dateFrom, $dateTo)
    {
        return $query->when($category, function ($query) use ($category) {
            return $query->where('category_id', $category);
        })->when($region, function ($query) use ($region) {
            return $query->whereRegion($region);
        })->when($admin, function ($query) use ($admin) {
            return $query->where('admin_id', $admin);
        })->when($status != '', function ($query) use ($status) {
            return $query->where('is_active', $status);
        })->whereDate('posts.created_at', '>=', $dateFrom)->whereDate('posts.created_at', '<=', $dateTo);
    }
}
