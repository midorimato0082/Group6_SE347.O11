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
            $categories = Category::where('is_active', 1)->orderBy('name', 'ASC')->take(5)->get();
            $locations = Location::where('is_active', 1)->orderBy('name', 'ASC')->take(20)->get();

            $bacReviews = Review::where('is_active', 1)->getRegion('Miền Bắc')->take(4)->get();
            $namReviews = Review::where('is_active', 1)->getRegion('Miền Nam')->take(4)->get();

            $view->with(['categories' => $categories, 'locations' => $locations, 'bacReviews' => $bacReviews, 'namReviews' => $namReviews]);
        });
    }
}
