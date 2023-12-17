<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Location;
use App\Models\Post;
use App\Models\Region;
use App\Models\Review;

class MenuPagesController extends Controller
{
    public function showCategoryPage($slug) {
        $category = Category::where('slug', $slug)->first();

        // Bài viết có nhiều lượt like thuộc danh mục
        $carouselPosts = Post::where('is_active', true)->where('category_id', $category->id)->count()->orderBy('like_count', 'DESC')->take(5)->get();
  
        return view('user.category-page', compact('carouselPosts', 'category'))->with('title', $category->name);
    }

    public function showRegionPage($slug) {
        $region = Region::where('slug', $slug)->first();

        // Bài viết có nhiều lượt like thuộc region
        $carouselPosts = Post::where('is_active', true)->whereRegion($region->name)->count()->orderBy('like_count', 'DESC')->take(5)->get();

        return view('user.region-page', compact('carouselPosts', 'region'))->with('title', $region->name);
    }

    public function showLocationPage($slug) {
        $location = Location::where('slug', $slug)->first();
        $reviewsCarousel = Review::where('is_active', 1)->where('location_id', $location->id)->count()->orderBy('like_count', 'DESC')->take(5)->get();
        $reviews = $location->reviews;
        $categories = Category::all('name', 'slug');

        return view('user.location-page', compact('reviewsCarousel', 'reviews', 'location', 'categories'))->with('title', $location->name);
    }

    

    public function showTagPage($slug) {
        $reviews = Review::query()->where('tags', "LIKE", "%{$slug}%")->get();

        $name = str_replace('-', ' ', $slug);

        $reviewsCarousel = $reviews->take(5);

        return view('user.tag-page', compact('reviewsCarousel', 'reviews', 'name'))->with('title', $name);
    }
}
