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

    public function locations()
    {
        return $this->hasMany(Location::class, 'location_id');
    }

    public function scopeWhereRegion($query, $region) // Hàm lấy name các location thuộc vùng $region. Ví dụ lấy các location thuộc miền bắc.
    {

        return $query->when($region, function ($query) use ($region) {
            return $query->whereRelation('region', 'name', $region);
        });
    }

        public function scopeSearch($query, $term)
        {
            return $query->when($term, function ($query) use ($term) {
                $term = '%' . trim($term) . '%';
                return $query->Where('locations.created_at', 'LIKE', $term)
                    ->orWhere('locations.updated_at', 'LIKE', $term);
            });
        }

        public function scopeFilter($query, $region, $status, $dateFrom, $dateTo)
        {
            return $query->when($region, function ($query) use ($region) {
                return $query->where('region_id', $region);
            })->when($status != '', function ($query) use ($status) {
                return $query->where('is_active', $status);
            })->whereDate('locations.created_at', '>=', $dateFrom)->whereDate('locations.created_at', '<=', $dateTo);
        }

        public function scopeSort($query, $sortBy, $sortDirection)
        {
            switch ($sortBy) {
                case 'region':
                    return $query->leftJoin('regions', 'locations.region_id', '=', 'regions.id')->orderBy('regions.name', $sortDirection);
                default:
                    return $query->orderBy($sortBy, $sortDirection);
            }
        }
}
