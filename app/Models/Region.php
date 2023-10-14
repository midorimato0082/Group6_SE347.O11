<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table = 'tbl_region';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'slug',
        'status',
    ];

    public function location()
    {
        return $this->hasMany(Location::class, 'location_id');
    }
}
