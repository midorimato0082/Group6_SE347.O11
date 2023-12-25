<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\District;
use App\Models\Place;
use App\Models\Post;
use App\Models\Province;
use App\Models\Region;
use App\Models\User;

class MenuPagesController extends Controller
{
    public function showCategoryPage($slug) {
        $category = Category::where('slug', $slug)->first();

        // Bài viết có nhiều lượt like thuộc danh mục
        $carouselPosts = Post::where('is_active', true)->where('category_id', $category->id)->count()->orderBy('like_count', 'DESC')->take(5)->get();
  
        return view('user.menu-pages.category-page', compact('carouselPosts', 'category'))->with('title', $category->name);
    }

    public function showRegionPage($slug) {
        $region = Region::where('slug', $slug)->first();

        $carouselPosts = Post::where('is_active', true)->whereRegion($region->name)->count()->orderBy('like_count', 'DESC')->take(5)->get();

        return view('user.menu-pages.region-page', compact('carouselPosts', 'region'))->with('title', $region->name);
    }

    public function showProvincePage($slug) {
        $province = Province::where('slug', $slug)->first();

        $carouselPosts = Post::where('is_active', true)->whereRelation('places.district.province', 'id', $province->id)->count()->orderBy('like_count', 'DESC')->take(5)->get();

        return view('user.menu-pages.province-page', compact('carouselPosts', 'province'))->with('title', $province->name);
    }

    public function showDistrictPage($slug) {
        $district = District::where('slug', $slug)->first();

        $carouselPosts = Post::where('is_active', true)->whereRelation('places.district', 'id', $district->id)->count()->orderBy('like_count', 'DESC')->take(5)->get();

        return view('user.menu-pages.district-page', compact('carouselPosts', 'district'))->with('title', $district->name);
    }

    public function showPlacePage($slug) {
        $place = Place::where('slug', $slug)->first();

        $carouselPosts = Post::where('is_active', true)->whereRelation('places', 'name', $place->name)->count()->orderBy('like_count', 'DESC')->take(5)->get();

        return view('user.menu-pages.place-page', compact('carouselPosts', 'place'))->with('title', $place->name);
    }

    public function showTagPage($tag) {

        $carouselPosts = Post::where('is_active', true)->where('tags', 'LIKE', '%'.$tag.'%')->count()->orderBy('like_count', 'DESC')->take(5)->get();

        return view('user.menu-pages.tag-page', compact('carouselPosts', 'tag'))->with('title', 'Tag: ' . $tag);
    }

    public function showAuthorPage($email) {
        $user = User::where('email', $email)->first();

        $carouselPosts = Post::where('is_active', true)->whereRelation('admin', 'email', $email)->count()->orderBy('like_count', 'DESC')->take(5)->get();

        return view('user.menu-pages.author-page', compact('carouselPosts', 'user'))->with('title', 'Tác giả: ' . $user->full_name);
    }
}
