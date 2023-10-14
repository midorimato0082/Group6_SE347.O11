<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'tbl_location';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'slug',
        'region_id',
        'status',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id'); 
    }

    public function review()
    {
        return $this->hasMany(Review::class, 'location_id');
    }
}
