<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'provinces';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'slug',
        'region_id'
    ];

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function districts()
    {
        return $this->hasMany(District::class, 'province_id');
    }

    public function places()
    {
        return $this->throughDistricts()->hasPlaces();
    }

    public function posts()
    {
        return $this->throughDistricts()->hasPosts();
    }

    public function scopeHasRegions($query, $regions)
    {
        return $query->when($regions, function ($query) use ($regions) {
            return $query->whereHas('region', fn($query) => $query->whereIn('name', $regions));
        });
    }

    public function scopeHasDistricts($query, $districts)
    {
        return $query->when($districts, function ($query) use ($districts) {
            return $query->whereHas('districts', fn($query) => $query->whereIn('name', $districts));
        });
    }

    // public function scopeWhereRegion($query, $region) // Hàm lấy name các location thuộc vùng $region. Ví dụ lấy các location thuộc miền bắc.
    // {
    //     return $query->when($region, function ($query) use ($region) {
    //         return $query->whereRelation('region', 'name', $region);
    //     });
    // }
}
