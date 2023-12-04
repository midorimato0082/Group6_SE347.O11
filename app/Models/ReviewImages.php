<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewImages extends Model
{
    protected $table = 'review_images';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'review_id',
        'is_active'
    ];

    public function review()
    {
        return $this->belongsTo(Review::class, 'review_id');
    }

    public function getUrlAttribute() {
        return asset('images/reviews/' . $this->name);
    }
}