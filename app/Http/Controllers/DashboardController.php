<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\News;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function viewDashboard()
    {
        $users = User::all();
        $comments = Comment::all();
        $news = News::all();
        $reviews = Review::all();
        return view('.admin.dashboard', compact('users', 'comments', 'news', 'reviews'))->with('title', 'Dashboard');
    }
}
