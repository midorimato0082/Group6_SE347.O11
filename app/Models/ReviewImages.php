<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function review()
    {
        return $this->belongsTo(Review::class, 'review_id');
    }

    protected function url(): Attribute
    {
        return new Attribute(
            get: fn () => asset('images/reviews/' . $this->name)
        );
    }
}