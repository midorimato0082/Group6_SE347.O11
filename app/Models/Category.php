<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'tbl_category';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'slug',
        'status',
    ];

    public function review()
    {
        return $this->hasMany(Review::class, 'category_id');
    }
}
