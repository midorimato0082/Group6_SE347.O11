<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Location;
use App\Models\Review;
use Illuminate\Http\Request;

class MenuPageController extends Controller
{
    public function viewCategoryPage($slug) {
        $category = Category::where('slug', $slug)->first();

        // Truyền biến $reviewsCarousel cho carousel-reviews.blade.php
        $reviewsCarousel = Review::where('is_active', 1)->where('category_id', $category->id)->orderBy('like_count', 'DESC')->take(5)->get();
        
        return view('.user.category-page', compact('reviewsCarousel'))->with('title', $category->name);
    }

    public function viewLocationPage($slug) {
        $location = Location::where('slug', $slug)->first();
        
        return view('.user.location-page', compact('reviewsCarousel'))->with('title', $location->name);
    }
}
