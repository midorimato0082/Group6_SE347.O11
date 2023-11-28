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
        return $this->belongsTo(Region::class, 'region_id'); 
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'location_id');
    }

    public function scopeGetRegion($query, $region) // Hàm lấy name các location thuộc vùng $region. Ví dụ lấy các location thuộc miền bắc.
    {
        return $query->when(!empty($region), function ($query) use ($region) {
            return $query->whereHas('region', function ($query) use ($region) {
                $query->select('name')->where('name', $region);
            });
        });
    }
}
