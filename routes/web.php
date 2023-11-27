<?php

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

// Login
Route::get('login', 'LoginController@viewLogin')->middleware('alreadyLoggedIn');
Route::get('logout', 'LoginController@logout');

// Reset Password
Route::get('forget-password', 'ResetPasswordController@viewForgetPassword')->middleware('alreadyLoggedIn');
Route::post('forget-password', 'ResetPasswordController@forgetPassword')->name('forget');
Route::get('reset/{email}/{code}', 'ResetPasswordController@viewResetPassword')->name('viewreset');
Route::post('reset-password', 'ResetPasswordController@resetPassword')->name('reset');

// Register
Route::get('register', 'RegisterController@viewRegister')->middleware('alreadyLoggedIn');
Route::post('register', 'RegisterController@register');
Route::get('verify/{code}', 'RegisterController@verifyAccount')->name('verify');

Route::middleware('isLoggedIn')->group(function () {
    // Dashboard
    Route::get('dashboard', 'DashboardController@viewDashboard');

    // User Management
    Route::get('all-user', 'UserController@viewAll');
    Route::get('edit-user/{id}', 'UserController@viewEdit');
    Route::post('update-user/{id}', 'UserController@update');
    Route::post('delete-user/{id}', 'UserController@delete');
    Route::post('delete-multiple-user', 'UserController@deleteMultiple');
    Route::get('add-admin', 'UserController@viewAddAdmin');
    Route::get('profile-admin', 'UserController@viewProfile');

    // Category Management
    Route::get('all-categories', 'CategoryController@viewAll');
    Route::get('edit-category/{id}', 'CategoryController@viewEdit');
    Route::post('update-category/{id}', 'CategoryController@update');
    Route::post('delete-category/{id}', 'CategoryController@delete');
    Route::get('add-category', 'CategoryController@viewAdd');
    Route::post('save-category', 'CategoryController@save');

    // Location Management
    Route::get('all-locations', 'LocationController@viewAll');
    Route::get('edit-location/{id}', 'LocationController@viewEdit');
    Route::post('update-location/{id}', 'LocationController@update');
    Route::post('delete-location/{id}', 'LocationController@delete');
    Route::get('add-location', 'LocationController@viewAdd');
    Route::post('save-location', 'LocationController@save');

    // Review Management
    Route::get('all-reviews', 'ReviewController@viewAll');
    Route::get('edit-review/{id}', 'ReviewController@viewEdit');
    Route::post('update-review/{id}', 'ReviewController@update');
    Route::post('delete-review/{id}', 'ReviewController@delete');
    Route::get('add-review', 'ReviewController@viewAdd');
    Route::post('save-review', 'ReviewController@save');

    // News Management
    Route::get('all-news', 'NewsController@viewAll');
    Route::get('edit-news/{id}', 'NewsController@viewEdit');
    Route::post('update-news/{id}', 'NewsController@update');
    Route::post('delete-news/{id}', 'NewsController@delete');
    Route::get('add-news', 'NewsController@viewAdd');
    Route::post('save-news', 'NewsController@save');

    // Comment Management
    Route::get('all-comments', 'CommentController@viewAll');
});

// Home Page - Tính
Route::get('', 'HomePageController@viewHomePage');

// Category Page - Nguyên
Route::get('/category/{slug}', 'MenuPageController@viewCategoryPage');

// Region Page - Nguyên
Route::get('/region/{slug}', 'MenuPageController@viewRegionPage');

// Location Page - Nguyên
Route::get('/location/{slug}', 'MenuPageController@viewLocationPage');

// Tag Page - Nguyên
Route::get('/tag/{tag}', 'MenuPageController@viewTagPage');

// Profile Page - Trí
Route::get('/profile', 'HomePageController@viewProfile');
// Home
Route::get('', 'HomeController@viewHome');

// Errors
Route::get('error/{code}', 'ErrorController@viewError');
