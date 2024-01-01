<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function showHome()
    {
        // Bài viết có nhiều lượt like
        $carouselPosts = Post::where('is_active', true)->count()->orderBy('like_count', 'DESC')->take(5)->get();

        // Bài viết về các địa điểm có rating cao
        $bestPlaces = Place::all()->sortByDesc('star')->take(6)->pluck('id');
        $bestPlacePosts = Post::where('is_active', true)->whereHas('places', function ($query) use ($bestPlaces) {
            $query->whereIn('places.id', $bestPlaces);
        })->take(6)->get();

        // Bài viết được xem nhiều nhất
        $bestViewPosts = Post::where('is_active', true)->orderBy('view_count', 'desc')->take(5)->get();

        // Bài viết mới nhất
        $latestPosts = Post::where('is_active', true)->latest()->take(6)->get();

        return view('user.home', compact('carouselPosts', 'bestPlacePosts', 'bestViewPosts', 'latestPosts'))->with('title', 'Trang chủ');
    }

    public function showProfile()
    {
        return Auth::user()->is_admin ? view('admin.profile')->with('title', 'Hồ sơ') : view('user.profile')->with('title', 'Hồ sơ');
    }
}
