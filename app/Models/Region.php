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
        return $this->hasMany(Location::class, 'location_id');
    }
}
