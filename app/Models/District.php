<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'districts';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'slug',
        'province_id'
    ];

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function places()
    {
        return $this->hasMany(Place::class, 'district_id');
    }

    public function posts()
    {
        return $this->throughPlaces()->hasPosts();
    }

    public function scopeHasProvinces($query, $provinces)
    {
        return $query->when($provinces, function ($query) use ($provinces) {
            return $query->whereHas('province', fn($query) => $query->whereIn('name', $provinces));
        });
    }

    // public function scopeWhereRegion($query, $region) // Hàm lấy name các location thuộc vùng $region. Ví dụ lấy các location thuộc miền bắc.
    // {
    //     return $query->when($region, function ($query) use ($region) {
    //         return $query->whereRelation('region', 'name', $region);
    //     });
    // }
}
