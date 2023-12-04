<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'locations';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'slug',
        'region_id',
        'is_active'
    ];

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id')->withDefault(function (Region $region) {
            $region->name = null;
        });; 
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'location_id');
    }

    public function scopeWhereRegion($query, $region) // Hàm lấy name các location thuộc vùng $region. Ví dụ lấy các location thuộc miền bắc.
    {
        return $query->when($region, function ($query) use ($region) {
            return $query->whereRelation('region', 'name', $region);
        });
    }
}
