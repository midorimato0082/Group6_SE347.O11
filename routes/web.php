<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuPagesController;
use App\Http\Controllers\PostController;
use App\Livewire\Admin\CategoryManagement\AllCategories;
use App\Livewire\Admin\CommentManagement\AllComments;
use App\Livewire\Admin\PlaceManagement\AllPlaces;
use App\Livewire\Admin\PostManagement\AddPost;
use App\Livewire\Admin\PostManagement\AllPosts;
use App\Livewire\Admin\PostManagement\EditPost;
use App\Livewire\Admin\UserManagement\AllUsers;
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

// Authentication
Auth::routes(['verify' => true]);

// Admin Pages
Route::middleware(['auth', 'auth.roles:Admin,Super Admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard');

    // User Management
    Route::get('/all-users', AllUsers::class);

    // Category Management
    Route::get('/all-categories', AllCategories::class);

    // Post Management
    Route::get('/all-posts', AllPosts::class);
    Route::get('/add-post', AddPost::class);
    Route::get('/edit-post/{post}', EditPost::class)->name('edit.post');

    // Place Management
    Route::get('/all-places', AllPlaces::class);

    // Comment Management
    Route::get('/all-comments', AllComments::class);
});

// Home Page
Route::get('/', [HomeController::class, 'showHome'])->name('home');

// Profile Page
Route::get('/profile', [HomeController::class, 'showProfile'])->middleware('auth'); 

// Menu Pages
Route::get('/category/{slug}', [MenuPagesController::class, 'showCategoryPage'])->name('category');
Route::get('/region/{slug}', [MenuPagesController::class, 'showRegionPage'])->name('region');
Route::get('/province/{slug}', [MenuPagesController::class, 'showProvincePage'])->name('province');
Route::get('/district/{slug}', [MenuPagesController::class, 'showDistrictPage'])->name('district');
Route::get('/place/{slug}', [MenuPagesController::class, 'showPlacePage'])->name('place');
Route::get('/tag/{tag}', [MenuPagesController::class, 'showTagPage'])->name('tag');
Route::get('/author/{email}', [MenuPagesController::class, 'showAuthorPage'])->name('author');

// Details Post
Route::get('/{slug}', [PostController::class, 'showPost'])->name('post');