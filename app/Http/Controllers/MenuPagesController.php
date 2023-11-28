<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Location;
use App\Models\Region;
use App\Models\Review;

class MenuPagesController extends Controller
{
    public function showCategoryPage($slug) {
        $category = Category::where('slug', $slug)->first();
        $reviews = $category->reviews;

        // Truyền biến $reviewsCarousel cho carousel-reviews.blade.php
        $reviewsCarousel = Review::where('is_active', 1)->where('category_id', $category->id)->count()->orderBy('like_count', 'DESC')->take(5)->get();

        return view('.user.category-page', compact('reviewsCarousel', 'category', 'reviews'))->with('title', $category->name);
    }

    public function showLocationPage($slug) {
        $location = Location::where('slug', $slug)->first();
        $reviewsCarousel = Review::where('is_active', 1)->where('location_id', $location->id)->count()->orderBy('like_count', 'DESC')->take(5)->get();
        $reviews = $location->reviews;
        $region = $location->region;

        return view('.user.location-page', compact('reviewsCarousel', 'reviews', 'location'))->with('title', $location->region->name . ' / ' . $location->name);
    }

    public function showRegionPage($slug) {
        $region = Region::where('slug', $slug)->first();
        $location = $region->locations[0];
        $reviewsCarousel = Review::where('is_active', 1)->where('location_id', $location->id)->count()->orderBy('like_count', 'DESC')->take(5)->get();

        $reviews = $region->reviews;

        return view('.user.region-page', compact('reviewsCarousel', 'reviews', 'region'))->with('title', $region->name);
    }

    public function showTagPage($slug) {
        $reviews = Review::query()->where('tags', "LIKE", "%{$slug}%")->get();

        $name = str_replace('-', ' ', $slug);

        $reviewsCarousel = $reviews->take(5);

        return view('.user.tag-page', compact('reviewsCarousel', 'reviews', 'name'))->with('title', $name);
    }
}