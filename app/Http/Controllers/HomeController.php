<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function showHome()
    {
        // Truyền biến $reviewsCarousel cho carousel-reviews.blade.php
        $reviewsCarousel = Review::where('is_active', 1)->count()->orderBy('like_count', 'DESC')->take(5)->get();
        $news = News::all();
        $reviews = Review::all();

        return view('user.home', compact('reviewsCarousel', 'news', 'reviews'))->with('title', 'Trang chủ');
    }

    public function showProfile() 
    {
        return view('.user.profile')->with('title', 'Hồ sơ');
    }
}
