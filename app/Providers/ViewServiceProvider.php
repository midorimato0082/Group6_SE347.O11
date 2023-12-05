<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Location;
use App\Models\Review;
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
            $categories = Category::orderBy('name', 'ASC')->get(['name', 'slug']);
            $locations = Location::where('is_active', 1)->orderBy('name', 'ASC')->get(['name', 'slug']);

            $bacReviews = Review::where('is_active', 1)->whereRegion('Miền Bắc')->take(3)->get(['id', 'title', 'slug', 'created_at']);
            $namReviews = Review::where('is_active', 1)->whereRegion('Miền Nam')->take(3)->get(['id', 'title', 'slug', 'created_at']);

            $view->with(['categories' => $categories, 'locations' => $locations, 'bacReviews' => $bacReviews, 'namReviews' => $namReviews]);
        });
    }
}
