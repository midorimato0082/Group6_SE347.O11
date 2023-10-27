<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'slug',
        'is_active',
    ];

    public function review()
    {
        return $this->hasMany(Review::class, 'category_id');
    }
}
