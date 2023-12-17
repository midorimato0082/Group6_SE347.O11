<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Province;
use App\Models\Region;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
       View::composer('layouts.user', function ($view) {
            $categories = Category::where('is_active', true)->where('is_place', true)->orderBy('name', 'asc')->get(['name', 'slug']);
            $provinces = Province::orderBy('name', 'asc')->get(['name', 'slug']);

            $bacPosts = Post::where('is_active', true)->whereRegion('Miền Bắc')->latest()->take(3)->get(['id', 'title', 'slug', 'created_at']);
            $trungPosts = Post::where('is_active', true)->whereRegion('Miền Trung')->latest()->take(3)->get(['id', 'title', 'slug', 'created_at']);

            $view->with(['categories' => $categories, 'provinces' => $provinces, 'bacPosts' => $bacPosts, 'trungPosts' => $trungPosts]);
        });
    }
}
