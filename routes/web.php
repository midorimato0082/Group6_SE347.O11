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
Route::get('delete-user/{id}', 'UserController@delete')->middleware('isLoggedIn');
Route::get('add-admin', 'UserController@viewAddAdmin')->middleware('isLoggedIn');
Route::post('save-admin', 'UserController@saveAdmin')->middleware('isLoggedIn');

// Category Management

// Location Management

// Review Management

// News Management

// Comment Management







// Home
Route::get('', 'HomeController@viewHome');

// Errors
Route::get('error/{code}', 'ErrorsController@viewError');
