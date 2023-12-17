<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'regions';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'slug'
    ];

    public function provinces()
    {
        return $this->hasMany(Province::class, 'region_id');
    }

    public function districts()
    {
        return $this->throughProvinces()->hasDistricts();
    }

    public function scopeHasProvinces($query, $provinces)
    {
        return $query->when($provinces, function ($query) use ($provinces) {
            return $query->whereHas('provinces', fn($query) => $query->whereIn('name', $provinces));
        });
    }

    public function scopeHasDistricts($query, $districts)
    {
        return $query->when($districts, function ($query) use ($districts) {
            return $query->whereHas('districts', fn($query) => $query->whereIn('districts.name', $districts));
        });
    }
}