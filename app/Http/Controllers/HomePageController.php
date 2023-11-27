<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\News;
use App\Models\User;

class HomePageController extends Controller
{
    public function viewHomePage() {
        // Truyền biến $reviewsCarousel cho carousel-reviews.blade.php
        $reviewsCarousel = Review::where('is_active', 1)->orderBy('like_count', 'DESC')->take(5)->get();
        $news = News::all();
        $reviews = Review::all();

        return view('.user.home-page', compact('reviewsCarousel', 'news', 'reviews'))->with('title', 'Trang chủ');
    }

    public function viewProfile() {

        return view('.user.profile')->with('title', 'Hồ sơ');
    }
}
