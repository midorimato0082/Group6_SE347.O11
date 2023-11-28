<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuPagesController;
use App\Http\Controllers\ReviewController;
use App\Livewire\Admin\ReviewManagement\AllReviews;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true]);

// Home Page
Route::get('/', [HomeController::class, 'showHome'])->name('home');

// Profile Page
Route::get('/profile', [HomeController::class, 'showProfile'])->middleware('auth'); 

// Menu Pages
Route::get('/category/{slug}', [MenuPagesController::class, 'showCategoryPage'])->name('category');
Route::get('/region/{slug}', [MenuPagesController::class, 'showRegionPage'])->name('region');
Route::get('/location/{slug}', [MenuPagesController::class, 'showLocationPage'])->name('location');
Route::get('/tag/{tag}', [MenuPagesController::class, 'showTagPage'])->name('tag');
Route::get('/author/{id}', [MenuPagesController::class, 'showAuthorPage'])->name('author');
Route::get('/news', [MenuPagesController::class, 'showNewsPage']);

// Details Content
Route::get('/review/{slug}', [ReviewController::class, 'showReview'])->name('review');
Route::get('/news/{slug}', [NewsController::class, 'showNews'])->name('news');

// Admin Pages
Route::middleware(['auth', 'auth.roles:Admin,Super Admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard');

    // User Management

    // Category Management

    // Location Management

    // Review Management

    // News Management

    // Comment Management

});


// Phần chưa update ---------------------------------------------------

// Route::middleware('isLoggedIn')->group(function () {
//     // Dashboard
//     Route::get('dashboard', 'DashboardController@viewDashboard');

//     // User Management
//     Route::get('all-users', 'UserController@viewAll');
//     Route::get('edit-admin/{id}', 'UserController@viewEdit');
//     Route::get('add-admin', 'UserController@viewAddAdmin');
//     Route::get('profile-admin', 'UserController@viewProfile');

//     // Category Management
//     Route::get('all-categories', 'CategoryController@viewAll');
//     Route::get('edit-category/{id}', 'CategoryController@viewEdit');
//     Route::post('update-category/{id}', 'CategoryController@update');
//     Route::post('delete-category/{id}', 'CategoryController@delete');
//     Route::get('add-category', 'CategoryController@viewAdd');
//     Route::post('save-category', 'CategoryController@save');

//     // Location Management
//     Route::get('all-locations', 'LocationController@viewAll');
//     Route::get('edit-location/{id}', 'LocationController@viewEdit');
//     Route::post('update-location/{id}', 'LocationController@update');
//     Route::post('delete-location/{id}', 'LocationController@delete');
//     Route::get('add-location', 'LocationController@viewAdd');
//     Route::post('save-location', 'LocationController@save');

//     // Review Management
//     Route::get('all-reviews', 'ReviewController@viewAll');
//     Route::get('edit-review/{id}', 'ReviewController@viewEdit');
//     Route::post('update-review/{id}', 'ReviewController@update');
//     Route::post('delete-review/{id}', 'ReviewController@delete');
//     Route::get('add-review', 'ReviewController@viewAdd');
//     Route::post('save-review', 'ReviewController@save');

//     // News Management
//     Route::get('all-news', 'NewsController@viewAll');
//     Route::get('edit-news/{id}', 'NewsController@viewEdit');
//     Route::post('update-news/{id}', 'NewsController@update');
//     Route::post('delete-news/{id}', 'NewsController@delete');
//     Route::get('add-news', 'NewsController@viewAdd');
//     Route::post('save-news', 'NewsController@save');

//     // Comment Management
//     Route::get('all-comments', 'CommentController@viewAll');
// });