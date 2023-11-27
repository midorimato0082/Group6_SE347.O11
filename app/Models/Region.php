<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'regions';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'slug',
        'is_active',
    ];

    public function locations()
    {
        return $this->hasMany(Location::class, 'region_id');
    }

    public function reviews()
    {
        return $this->hasManyThrough(Review::class, Location::class, 'region_id', 'location_id');
    }
}
