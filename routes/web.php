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
Route::group(['namespace' => '\App\Http\Controllers'], function () {
    // Login
    Route::get('login', 'LoginController@viewLogin')->middleware('alreadyLoggedIn');
    Route::post('login', 'LoginController@login');
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

    // Dashboard
    Route::get('dashboard', 'DashboardController@viewDashboard')->middleware('isLoggedIn');

    // User Management
    Route::get('all-user', 'UserController@viewAll')->middleware('isLoggedIn');
    Route::get('edit-user/{id}', 'UserController@viewEdit')->middleware('isLoggedIn');
    Route::post('update-user/{id}', 'UserController@update')->middleware('isLoggedIn');
    Route::post('delete-user/{id}', 'UserController@delete')->middleware('isLoggedIn');
    Route::get('add-admin', 'UserController@viewAddAdmin')->middleware('isLoggedIn');
    Route::post('save-admin', 'UserController@saveAdmin')->middleware('isLoggedIn');


    // Category Management
    Route::get('all-category', 'CategoryController@viewAll')->middleware('isLoggedIn');
    Route::get('edit-category/{id}', 'CategoryController@viewEdit')->middleware('isLoggedIn');
    Route::post('update-category/{id}', 'CategoryController@update')->middleware('isLoggedIn');
    Route::post('delete-category/{id}', 'CategoryController@delete')->middleware('isLoggedIn');
    Route::get('add-category', 'CategoryController@viewAdd')->middleware('isLoggedIn');
    Route::post('save-category', 'CategoryController@save')->middleware('isLoggedIn');

    // Location Management
    Route::get('all-location', 'LocationController@viewAll')->middleware('isLoggedIn');
    Route::get('edit-location/{id}', 'LocationController@viewEdit')->middleware('isLoggedIn');
    Route::post('update-location/{id}', 'LocationController@update')->middleware('isLoggedIn');
    Route::post('delete-location/{id}', 'LocationController@delete')->middleware('isLoggedIn');
    Route::get('add-location', 'LocationController@viewAdd')->middleware('isLoggedIn');
    Route::post('save-location', 'LocationController@save')->middleware('isLoggedIn');

    // Review Management
    Route::get('all-review', 'ReviewController@viewAll')->middleware('isLoggedIn');
    Route::get('edit-review/{id}', 'ReviewController@viewEdit')->middleware('isLoggedIn');
    Route::post('update-review/{id}', 'ReviewController@update')->middleware('isLoggedIn');
    Route::post('delete-review/{id}', 'ReviewController@delete')->middleware('isLoggedIn');
    Route::get('add-review', 'ReviewController@viewAdd')->middleware('isLoggedIn');
    Route::post('save-review', 'ReviewController@save')->middleware('isLoggedIn');

    // News Management
    Route::get('all-news', 'NewsController@viewAll')->middleware('isLoggedIn');
    Route::get('edit-news/{id}', 'NewsController@viewEdit')->middleware('isLoggedIn');
    Route::post('update-news/{id}', 'NewsController@update')->middleware('isLoggedIn');
    Route::post('delete-news/{id}', 'NewsController@delete')->middleware('isLoggedIn');
    Route::get('add-news', 'NewsController@viewAdd')->middleware('isLoggedIn');
    Route::post('save-news', 'NewsController@save')->middleware('isLoggedIn');

    // Comment Management
    Route::get('all-comment', 'CommentController@viewAll')->middleware('isLoggedIn');
    Route::post('delete-comment/{id}', 'CommentController@delete')->middleware('isLoggedIn');







    // Home
    Route::get('', 'HomeController@viewHome');

    // Errors
    Route::get('error/{code}', 'ErrorsController@viewError');
});
