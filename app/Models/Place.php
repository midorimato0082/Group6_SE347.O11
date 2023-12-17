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
            $category->name = null;
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

    // Lấy trung bình sao mà place đạt được
    protected function star(): Attribute
    {
        return new Attribute(
            get: fn () => ($this->countStar(1) + $this->countStar(2) * 2 + $this->countStar(3) * 3 + $this->countStar(4) * 4 + $this->countStar(5) * 5) / ($this->users->count() ? $this->users->count() : 1)
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