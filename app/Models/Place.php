<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $table = 'places';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'address',
        'district_id',
        'min_price',
        'max_price',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected $appends = ['star'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->withDefault(function (Category $category) {
            $category->name = 'Deleted';
        });
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'reviews', 'place_id', 'post_id')->using(Review::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'ratings', 'place_id', 'user_id')->withPivot('star')->using(Rating::class);
    }

    // Format giá tiền có comma
    protected function lowestPrice(): Attribute
    {
        return new Attribute(
            get: fn () => number_format($this->min_price, 0, '.', ',') . '<sup>đ</sup>'
        );
    }

    protected function highestPrice(): Attribute
    {
        return new Attribute(
            get: fn () => number_format($this->max_price, 0, '.', ',') . '<sup>đ</sup>'
        );
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

    // Tên các bài viết có review địa điểm
    protected function getPostsTitleAttribute()
    {
        $posts = array();
        foreach ($this->posts as $post)
            $posts[] = $post->title;

        return implode(', ', $posts);
    }

    // Lấy trung bình sao mà place đạt được
    protected function star(): Attribute
    {
        return new Attribute(
            get: fn () => round(($this->countStar(1) + $this->countStar(2) * 2 + $this->countStar(3) * 3 + $this->countStar(4) * 4 + $this->countStar(5) * 5) / ($this->users->count() ? $this->users->count() : 1), 2)
        );
    }

    // Lấy tên tooltip cho sao
    protected function starTooltip(): Attribute
    {
        return new Attribute(
            get: fn () => $this->star >= 5 ? 'Tuyệt vời' : ($this->star >= 4 ? 'Tốt' : ($this->star >= 3 ? 'Ổn' : ($this->star >= 2 ? 'Hơi tệ' : 'Rất tệ')))
        );
    }

    // Đếm số lượng user rating mỗi sao
    public function countStar($star)
    {
        return $this->users->where('pivot.star', $star)->count();
    }

    // Search
    public function scopeSearch($query, $term)
    {
        return $query->when($term, function ($query) use ($term) {
            $term = '%' . trim($term) . '%';
            return $query->where('places.name', 'LIKE', $term)
                ->orWhereRelation('category', 'name', 'LIKE', $term)
                ->orWhere('address', 'LIKE', $term)
                ->orWhereRelation('district', 'name', 'LIKE', $term)
                ->orWhereRelation('district.province', 'name', 'LIKE', $term)
                ->orWhereRelation('posts', 'title', 'LIKE', $term)
                ->orWhere('places.created_at', 'LIKE', $term)
                ->orWhere('places.updated_at', 'LIKE', $term);
        });
    }

    // Sắp xếp
    public function scopeSort($query, $sortBy, $sortDirection)
    {
        switch ($sortBy) {
            case 'category':
                return $query->select('places.*', 'categories.name as categoryName')
                    ->leftJoin('categories', 'places.category_id', '=', 'categories.id')
                    ->orderBy('categories.name', $sortDirection);
            case 'district':
                return $query->select('places.*', 'districts.name as districtName')
                    ->leftJoin('districts', 'places.district_id', '=', 'districts.id')
                    ->orderBy('districts.name', $sortDirection);
            case 'province':
                return $query->select('places.*', 'districts.name as districtName', 'provinces.name as provinceName')
                    ->leftJoin('districts', 'places.district_id', '=', 'districts.id')
                    ->leftJoin('provinces', 'districts.province_id', '=', 'provinces.id')
                    ->orderBy('provinces.name', $sortDirection);
            case 'region':
                return $query->select('places.*', 'districts.name as districtName', 'provinces.name as provinceName', 'regions.name as regionName')
                    ->leftJoin('districts', 'places.district_id', '=', 'districts.id')
                    ->leftJoin('provinces', 'districts.province_id', '=', 'provinces.id')
                    ->leftJoin('regions', 'provinces.region_id', '=', 'regions.id')
                    ->orderBy('regions.name', $sortDirection);
            case 'rating':
                $places = $sortDirection === 'asc' ? $query->get()->sortBy('star') : $query->get()->sortByDesc('star');
                $ids = $places->pluck('id')->toArray();
                $sortedIds = implode(',', $ids);
                return $query->orderByRaw("FIELD(id, $sortedIds)");
            case 'posts':
                $places = $sortDirection === 'asc' ? $query->get()->sortBy('posts_title') : $query->get()->sortByDesc('posts_title');
                $ids = $places->pluck('id')->toArray();
                $sortedIds = implode(',', $ids);
                return $query->orderByRaw("FIELD(id, $sortedIds)");
            default:
                return $query->orderBy($sortBy, $sortDirection);
        }
    }

    // Lọc
    public function scopeFilter($query, $category, $region, $rating, $status, $dateFrom, $dateTo)
    {
        return $query->when($category, function ($query) use ($category) {
            return $query->where('category_id', $category);
        })->when($region, function ($query) use ($region) {
            return $query->whereRelation('district.province.region', 'name', $region);
        })->when($rating, function ($query) use ($rating) {
            $ids = $query->get()->where('star', '>=', $rating)->pluck('id');
            return $query->when($ids, fn ($query) => $query->whereIn('id', $ids));
        })->when($status != '', function ($query) use ($status) {
            return $query->where('is_active', $status);
        })->whereDate('places.created_at', '>=', $dateFrom)->whereDate('places.created_at', '<=', $dateTo);
    }


    // Đếm tổng số sao
    // public function sumStar()
    // {
    //     return $this->users->sum('pivot.star');
    // }

    // public function scopeSumStar($query) {
    //     return $query->withSum('users as total_stars', 'ratings.star');
    // }

    // // Lấy số lượng người dùng rating mỗi địa điểm
    // // protected function numberOfUserRatings(): Attribute
    // // {
    // //     return new Attribute(
    // //         get: fn () => $this->ratings->count('pivot.star')
    // //     );
    // // }

    // // Lấy những địa điểm có số sao tương ứng
    // public function scopeHasStar($query, $star)
    // {
    //     return $query->whereRelation('users', 'star', $star);
    // }



    // // Tính số lượng người dùng rating mỗi địa điểm
    // public function scopeCountRating($query)
    // {
    //     return $query->withCount('users');
    // }
}
